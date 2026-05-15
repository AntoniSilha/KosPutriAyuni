<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    use Notifiable;

    protected $table = 'users';

    protected $primaryKey = 'id_user';

    protected $fillable = [
        'name',
        'no_ktp',
        'email',
        'password',
        'no_hp',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // DB doesn't have remember_token column
    public $rememberTokenName = null;

    const UPDATED_AT = 'updated_at';

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user has active booking (penghuni)
     */
    public function isPenghuni(): bool
    {
        return $this->bookings()->whereIn('status', ['confirmed'])->exists();
    }

    /**
     * Determine if user can access Filament panel
     */
    public function canAccessPanel(Panel $panel): bool
    {
        if ($panel->getId() === 'admin') {
            return $this->isAdmin();
        }

        if ($panel->getId() === 'resident') {
            return ! $this->isAdmin();
        }

        return false;
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'users_id_user');
    }

    public function booking(): HasOne
    {
        return $this->hasOne(Booking::class, 'users_id_user');
    }

    public function activeBooking(): HasOne
    {
        return $this->hasOne(Booking::class, 'users_id_user')
            ->where('status', 'confirmed')
            ->latest('created_at');
    }
}
