<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Payment extends Model
{
    protected $table = 'payments';
    protected $primaryKey = 'id_payment';

    protected $fillable = [
        'transaction_id',
        'payment_method',
        'total_pembayaran',
        'payment_status',
        'payment_time',
        'bookings_id_booking',
    ];

    const CREATED_AT = null;
    const UPDATED_AT = null;

    protected function casts(): array
    {
        return [
            'total_pembayaran' => 'decimal:0',
            'payment_time' => 'datetime',
        ];
    }

    /**
     * Check if payment is successful
     */
    public function isPaid(): bool
    {
        return $this->payment_status === 'approve';
    }

    /**
     * Get human-readable status
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->payment_status) {
            'pending' => 'Menunggu Pembayaran',
            'approve' => 'Lunas',
            'rejected' => 'Gagal',
            'refund' => 'Refund',
            default => ucfirst($this->payment_status),
        };
    }

    /**
     * Get status color for badges
     */
    public function getStatusColorAttribute(): string
    {
        return match ($this->payment_status) {
            'pending' => 'warning',
            'approve' => 'success',
            'rejected' => 'danger',
            'refund' => 'info',
            default => 'secondary',
        };
    }

    /**
     * Get formatted amount
     */
    public function getFormattedAmountAttribute(): string
    {
        return 'Rp ' . number_format($this->total_pembayaran, 0, ',', '.');
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class, 'bookings_id_booking');
    }

    public function billingPenghuni(): HasOne
    {
        return $this->hasOne(BillingPenghuni::class, 'payments_id_payment');
    }

    public function refund(): HasOne
    {
        return $this->hasOne(Refund::class, 'payments_id_payment');
    }
}
