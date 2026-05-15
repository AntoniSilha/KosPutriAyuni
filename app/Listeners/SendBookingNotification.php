<?php

namespace App\Listeners;

use App\Events\BookingCreated;
use App\Services\WhatsAppService;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendBookingNotification implements ShouldQueue
{
    public function __construct(
        protected WhatsAppService $whatsAppService
    ) {}

    public function handle(BookingCreated $event): void
    {
        $booking = $event->booking;
        $booking->load(['user', 'room']);

        $room = 'Kamar ' . ($booking->room->no_kamar ?? 'N/A');
        $amount = 'Rp ' . number_format($booking->total_price, 0, ',', '.');

        // Admin is no longer notified here to prevent double messages.
        // Admin will only be notified when payment is successful.
    }
}
