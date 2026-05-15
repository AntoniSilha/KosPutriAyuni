<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;

class BookingPolicy
{
    /**
     * Determine if user can view any bookings
     */
    public function viewAny(User $user): bool
    {
        return true; // All authenticated users can see the list (filtered by ownership)
    }

    /**
     * Determine if user can view a specific booking
     */
    public function view(User $user, Booking $booking): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $booking->users_id_user === $user->id_user;
    }

    /**
     * Determine if user can create a booking
     * Only non-admin users can create bookings
     */
    public function create(User $user): bool
    {
        return !$user->isAdmin();
    }

    /**
     * Determine if user can update a booking
     */
    public function update(User $user, Booking $booking): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        // Users can only cancel their own pending bookings
        return $booking->users_id_user === $user->id_user
            && $booking->status === 'pending';
    }

    /**
     * Determine if user can delete a booking
     */
    public function delete(User $user, Booking $booking): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if user can pay for a booking
     */
    public function pay(User $user, Booking $booking): bool
    {
        if ($user->isAdmin()) {
            return false; // Admin doesn't pay
        }

        return $booking->users_id_user === $user->id_user
            && $booking->status === 'pending'
            && !$booking->isExpired();
    }
}
