<?php

namespace App\Policies;

use App\Models\Refund;
use App\Models\User;

class RefundPolicy
{
    /**
     * Determine if user can view any refunds
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine if user can view a specific refund
     */
    public function view(User $user, Refund $refund): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $refund->payment && $refund->payment->booking 
            && $refund->payment->booking->users_id_user === $user->id_user;
    }

    /**
     * Determine if user can create a refund
     */
    public function create(User $user): bool
    {
        return !$user->isAdmin();
    }

    /**
     * Determine if user can update a refund
     */
    public function update(User $user, Refund $refund): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if user can delete a refund
     */
    public function delete(User $user, Refund $refund): bool
    {
        return $user->isAdmin();
    }
}
