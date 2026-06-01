<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use App\Events\BookingCreated;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class BookingService
{
    /**
     * Create a new booking
     */
    public function createBooking(User $user, Room $room, array $data): Booking
    {
        // Validate room is available
        $this->validateRoomAvailability($room);

        // Validate no double booking
        $this->validateNoDoubleBooking($user, $room, $data['check_in']);

        // Calculate total price
        $months = 1;
        if (!empty($data['check_in']) && !empty($data['check_out'])) {
            $checkIn = \Carbon\Carbon::parse($data['check_in']);
            $checkOut = \Carbon\Carbon::parse($data['check_out']);
            $months = max(1, $checkIn->diffInMonths($checkOut));
        }

        $totalPrice = $room->harga_perbulan * $months;

        $booking = Booking::create([
            'invoice_number' => $this->generateInvoiceNumber(),
            'check_in' => $data['check_in'],
            'status' => 'pending',
            'users_id_user' => $user->id_user,
            'rooms_id_room' => $room->id_room,
        ]);

        // Create initial payment record to store the total price
        // because the bookings table doesn't have a price column
        \App\Models\Payment::create([
            'bookings_id_booking' => $booking->id_booking,
            'transaction_id' => $booking->invoice_number,
            'total_pembayaran' => $totalPrice,
            'payment_status' => 'pending',
            'payment_time' => now(),
        ]);

        // Fire event
        event(new BookingCreated($booking));

        return $booking;
    }

    /**
     * Validate room availability
     */
    public function validateRoomAvailability(Room $room): void
    {
        if (!$room->isAvailable()) {
            throw ValidationException::withMessages([
                'room' => 'Kamar ini sudah tidak tersedia.',
            ]);
        }

        // Check if room has active bookings
        $activeBooking = $room->activeBooking;
        if ($activeBooking) {
            throw ValidationException::withMessages([
                'room' => 'Kamar ini sedang dalam proses booking.',
            ]);
        }
    }

    /**
     * Validate no double booking for same user and room
     */
    public function validateNoDoubleBooking(User $user, Room $room, string $checkIn): void
    {
        // Check if user already has an active booking
        $query = Booking::where('users_id_user', $user->id_user)
            ->whereIn('status', ['pending', 'confirmed']);

        if ($query->exists()) {
            throw ValidationException::withMessages([
                'booking' => 'Anda masih memiliki booking aktif. Selesaikan atau batalkan terlebih dahulu.',
            ]);
        }

        // Check if room is already taken by someone else
        // This is a safety check in addition to validateRoomAvailability
        $roomQuery = Booking::where('rooms_id_room', $room->id_room)
            ->whereIn('status', ['pending', 'confirmed']);

        if ($roomQuery->exists()) {
            throw ValidationException::withMessages([
                'room' => 'Kamar ini sudah dibooking oleh orang lain.',
            ]);
        }
    }

    /**
     * Approve a booking
     */
    public function approveBooking(Booking $booking): Booking
    {
        $booking->update(['status' => 'confirmed']);

        // Update room status
        $booking->room->update(['status' => 'tidak tersedia']);

        return $booking->fresh();
    }

    /**
     * Reject a booking
     */
    public function rejectBooking(Booking $booking): Booking
    {
        $booking->update(['status' => 'cancelled']);

        return $booking->fresh();
    }

    /**
     * Delete unpaid bookings older than 24 hours.
     *
     * The Booking model's `deleting` event automatically handles:
     * - Deleting the related payment record
     * - Restoring the room status to 'tersedia' when appropriate
     */
    public function expireOldBookings(): int
    {
        $expiredBookings = Booking::where('status', 'pending')
            ->where('created_at', '<', now()->subHours(24))
            ->get();

        $count = 0;
        foreach ($expiredBookings as $booking) {
            \Log::info("Auto-deleting expired booking #{$booking->id_booking} (Invoice: {$booking->invoice_number}), created at {$booking->created_at}");
            $booking->delete();
            $count++;
        }

        return $count;
    }

    /**
     * Generate unique invoice number
     */
    protected function generateInvoiceNumber(): string
    {
        return 'INV-' . date('Ymd') . '-' . strtoupper(Str::random(6));
    }
}
