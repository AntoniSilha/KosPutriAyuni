<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Booking extends Model
{
    protected $table = 'bookings';
    protected $primaryKey = 'id_booking';

    protected static function booted()
    {
        static::deleting(function (Booking $booking) {
            // Hapus payment terkait secara otomatis agar tidak error constraint database
            if ($booking->payment) {
                $booking->payment->delete();
            }
            // Kembalikan status kamar menjadi tersedia jika pesanan dihapus dan tidak ada pesanan aktif lainnya
            if ($booking->room && $booking->room->status === 'tidak tersedia') {
                $hasOtherActiveBookings = static::where('rooms_id_room', $booking->rooms_id_room)
                    ->whereIn('status', ['pending', 'confirmed'])
                    ->where('id_booking', '!=', $booking->id_booking)
                    ->exists();

                if (!$hasOtherActiveBookings) {
                    $booking->room->update(['status' => 'tersedia']);
                }
            }
        });
    }

    protected $fillable = [
        'invoice_number',
        'check_in',
        'status',
        'rooms_id_room',
        'users_id_user',
    ];

    protected $appends = ['total_price'];

    /**
     * Get total price from related payment
     */
    public function getTotalPriceAttribute()
    {
        return $this->payment?->total_pembayaran ?? 0;
    }

    const UPDATED_AT = null;

    protected function casts(): array
    {
        return [
            'check_in' => 'date',
            'created_at' => 'datetime',
        ];
    }

    /**
     * Scope: pending bookings
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope: confirmed bookings
     */
    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    /**
     * Scope: cancelled bookings
     */
    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    /**
     * Scope: active bookings (pending or confirmed)
     */
    public function scopeActive($query)
    {
        return $query->whereIn('status', ['pending', 'confirmed']);
    }

    /**
     * Check if booking is expired (pending > 24h)
     */
    public function isExpired(): bool
    {
        return $this->status === 'pending'
            && $this->created_at
            && $this->created_at->addHours(24)->isPast();
    }

    /**
     * Get human-readable status label
     */
    public function getStatusLabelAttribute(): string
    {
        if ($this->isExpired()) {
            return 'Expired';
        }

        return match ($this->status) {
            'pending' => 'Menunggu Pembayaran',
            'confirmed' => 'Dikonfirmasi',
            'cancelled' => 'Dibatalkan',
            'refund' => 'Pengembalian Dana',
            default => ucfirst($this->status),
        };
    }

    /**
     * Get status color for badges
     */
    public function getStatusColorAttribute(): string
    {
        if ($this->isExpired()) {
            return 'gray';
        }

        return match ($this->status) {
            'pending' => 'warning',
            'confirmed' => 'success',
            'cancelled' => 'danger',
            'refund' => 'info',
            default => 'secondary',
        };
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'users_id_user');
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class, 'rooms_id_room');
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class, 'bookings_id_booking');
    }
}
