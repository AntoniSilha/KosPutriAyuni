<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Refund;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class RefundController extends Controller
{
    /**
     * Store a new refund request
     */
    public function store(Request $request, int $id)
    {
        $booking = Booking::with(['payment', 'room'])->findOrFail($id);

        // Authorize: only own booking or admin can view/refund
        Gate::authorize('view', $booking);

        // Check if the booking can be refunded
        if (!$booking->canBeRefunded()) {
            return redirect()->back()->with('error', 'Pesanan ini tidak dapat dibatalkan atau di-refund.');
        }

        // Validate reason
        $request->validate([
            'reason' => 'required|string|max:1000',
        ], [
            'reason.required' => 'Alasan pembatalan harus diisi.',
            'reason.max' => 'Alasan pembatalan tidak boleh lebih dari 1000 karakter.',
        ]);

        DB::transaction(function () use ($booking, $request) {
            // 1. Create Refund record
            Refund::create([
                'reason' => $request->reason,
                'total' => $booking->payment->total_pembayaran,
                'status' => 'approved',
                'refund_time' => now(),
                'payments_id_payment' => $booking->payment->id_payment,
            ]);

            // 2. Update payment status to refund
            $booking->payment->update([
                'payment_status' => 'refund',
            ]);

            // 3. Update booking status to refund
            $booking->update([
                'status' => 'refund',
            ]);

            // 4. Update room status to tersedia if no other active bookings
            if ($booking->room && $booking->room->status === 'tidak tersedia') {
                $otherActiveBookings = Booking::where('rooms_id_room', $booking->rooms_id_room)
                    ->whereIn('status', ['pending', 'confirmed'])
                    ->where('id_booking', '!=', $booking->id_booking)
                    ->with(['payment', 'room'])
                    ->get();

                // Filter: only count bookings that are truly active
                // (pending, or confirmed with an active lease)
                $hasOtherActiveBookings = $otherActiveBookings->contains(function ($b) {
                    if ($b->status === 'pending') {
                        return true;
                    }
                    // For confirmed bookings, check if lease is still active
                    return !$b->isLeaseExpired();
                });

                if (!$hasOtherActiveBookings) {
                    $booking->room->update(['status' => 'tersedia']);
                }
            }
        });

        return redirect()->route('pesanan.show', $booking->id_booking)
            ->with('success', 'Perpanjangan sewa berhasil dibatalkan dan pengembalian dana telah diajukan.');
    }
}
