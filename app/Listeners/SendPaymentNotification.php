<?php

namespace App\Listeners;

use App\Events\PaymentReceived;
use App\Services\WhatsAppService;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendPaymentNotification implements ShouldQueue
{
    public function __construct(
        protected WhatsAppService $whatsAppService
    ) {}

    public function handle(PaymentReceived $event): void
    {
        $payment = $event->payment;
        $payment->load(['booking.user', 'booking.room']);

        $booking = $payment->booking;
        $room = 'Kamar ' . ($booking->room->no_kamar ?? 'N/A');
        $amount = 'Rp ' . number_format($payment->total_pembayaran, 0, ',', '.');

        // Notify admin
        $this->whatsAppService->notifyAdminPaymentReceived(
            $booking->user->name ?? 'Unknown',
            $room,
            $amount,
            $booking->invoice_number ?? '-'
        );
    }
}
