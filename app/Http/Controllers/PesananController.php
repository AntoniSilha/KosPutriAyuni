<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    public function __construct(
        protected PaymentService $paymentService
    ) {}

    /**
     * List all bookings for authenticated user
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        $query = $user->bookings()
            ->with(['room.images', 'payment'])
            ->latest('created_at');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $bookings = $query->paginate(10);

        return view('pesanan.index', compact('bookings'));
    }

    /**
     * Show booking detail
     */
    public function show(Request $request, int $id)
    {
        $booking = Booking::with(['room.images', 'payment', 'user'])
            ->findOrFail($id);

        // Policy check: only own booking or admin
        \Illuminate\Support\Facades\Gate::authorize('view', $booking);

        // Calculate duration from payment total / price per month
        $duration = 1;
        if ($booking->payment && $booking->room->harga_perbulan > 0) {
            $duration = (int) round($booking->payment->total_pembayaran / $booking->room->harga_perbulan);
            $duration = max(1, $duration);
        }

        // Generate snap token if payment pending
        $snapToken = null;
        $refreshLimitReached = false;
        $maxRefresh = 3;

        if ($booking->status === 'pending' && !$booking->isExpired()) {
            $cacheKey = "snap_token_{$booking->id_booking}";
            $refreshCountKey = "snap_refresh_count_{$booking->id_booking}";
            $forceRefresh = $request->has('refresh_token');
            $refreshCount = (int) cache()->get($refreshCountKey, 0);

            // Check if refresh limit is reached
            if ($forceRefresh && $refreshCount >= $maxRefresh) {
                $refreshLimitReached = true;
                $forceRefresh = false; // Block the refresh, use cached token instead
            }

            // Use cached token if available (preserves already-selected payment method)
            if (!$forceRefresh && cache()->has($cacheKey)) {
                $snapToken = cache()->get($cacheKey);
            } else {
                // Clear old cache & increment counter if forcing refresh
                if ($forceRefresh) {
                    cache()->forget($cacheKey);
                    cache()->put($refreshCountKey, $refreshCount + 1, now()->addHours(5));
                    $refreshCount++;
                }

                try {
                    $snapToken = $this->paymentService->createSnapToken($booking);
                } catch (\Exception $e) {
                    $errorMessage = strtolower($e->getMessage());
                    $isReusedOrderId = str_contains($errorMessage, 'has been used') || 
                                       str_contains($errorMessage, 'has already been taken') || 
                                       str_contains($errorMessage, 'sudah digunakan');
                                       
                    // If Midtrans rejects the order_id (cancelled/failed previously)
                    if ($isReusedOrderId || ($booking->payment && $booking->payment->payment_status === 'rejected')) {
                        $booking->invoice_number = 'INV-' . date('Ymd') . '-' . strtoupper(\Illuminate\Support\Str::random(6));
                        $booking->save();
                        
                        try {
                            $snapToken = $this->paymentService->createSnapToken($booking);
                        } catch (\Exception $retryException) {
                            \Log::error('Snap token retry error: ' . $retryException->getMessage());
                        }
                    } else {
                        \Log::error('Snap token error: ' . $errorMessage);
                    }
                }

                // Cache the token for 30 minutes (Midtrans tokens expire after ~24h)
                if ($snapToken) {
                    cache()->put($cacheKey, $snapToken, now()->addMinutes(30));
                }
            }

            // Update limit status after potential increment
            if ($refreshCount >= $maxRefresh) {
                $refreshLimitReached = true;
            }
        }

        $refreshRemaining = $maxRefresh - (int) cache()->get("snap_refresh_count_{$booking->id_booking}", 0);

        return response()
            ->view('pesanan.show', compact('booking', 'duration', 'snapToken', 'refreshLimitReached', 'refreshRemaining'))
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    /**
     * Show invoice
     */
    public function invoice(int $id)
    {
        $booking = Booking::with(['room', 'payment', 'user'])
            ->findOrFail($id);

        \Illuminate\Support\Facades\Gate::authorize('view', $booking);

        return view('pesanan.invoice', compact('booking'));
    }
}
