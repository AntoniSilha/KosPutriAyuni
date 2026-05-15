<?php

namespace App\Http\Controllers;

use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function __construct(
        protected PaymentService $paymentService
    ) {}

    /**
     * Handle Midtrans webhook/callback notification
     */
    public function notification(Request $request)
    {
        Log::info('Midtrans webhook received', $request->all());

        try {
            $payment = $this->paymentService->handleNotification($request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'Notification processed',
            ]);
        } catch (\Exception $e) {
            Log::error('Midtrans webhook error: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Handle payment finish redirect from Midtrans
     */
    public function finish(Request $request)
    {
        $orderId = $request->order_id;
        
        // Manual check as fallback for localhost missing webhooks
        if ($orderId) {
            $this->paymentService->checkStatusManual($orderId);
        }

        return redirect()->route('pesanan.index')
            ->with('success', 'Pembayaran berhasil diproses. Terima kasih!');
    }

    /**
     * Handle unfinished payment redirect
     */
    public function unfinish(Request $request)
    {
        return redirect()->route('pesanan.index')
            ->with('warning', 'Pembayaran belum selesai. Silakan coba lagi.');
    }

    /**
     * Handle payment error redirect
     */
    public function error(Request $request)
    {
        return redirect()->route('pesanan.index')
            ->with('error', 'Pembayaran gagal. Silakan coba lagi atau hubungi admin.');
    }
}
