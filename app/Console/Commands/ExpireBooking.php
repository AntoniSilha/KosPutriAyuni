<?php

namespace App\Console\Commands;

use App\Services\BookingService;
use Illuminate\Console\Command;

class ExpireBooking extends Command
{
    protected $signature = 'booking:expire';
    protected $description = 'Expire unpaid bookings older than 24 hours';

    public function handle(BookingService $bookingService): int
    {
        $this->info('Checking for expired bookings...');

        $count = $bookingService->expireOldBookings();

        $this->info("Expired {$count} booking(s).");

        return self::SUCCESS;
    }
}
