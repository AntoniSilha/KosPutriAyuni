<?php

namespace App\Policies;

use App\Models\Payment;
use App\Models\User;

class PaymentPolicy
{
    /**
     * Determine if user can view any payments
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine if user can view a specific payment
     */
    public function view(User $user, Payment $payment): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $payment->booking
            && $payment->booking->users_id_user === $user->id_user;
    }

    /**
     * Determine if user can create a payment
     */
    public function create(User $user): bool
    {
        return !$user->isAdmin();
    }

    /**
     * Determine if user can update a payment
     */
    public function update(User $user, Payment $payment): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if user can delete a payment
     */
    public function delete(User $user, Payment $payment): bool
    {
        return $user->isAdmin();
    }
}
