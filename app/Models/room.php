<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Room extends Model
{
    protected $table = 'rooms';
    protected $primaryKey = 'id_room';

    public $timestamps = false;

    protected $fillable = [
        'no_kamar',
        'deskripsi',
        'harga_perbulan',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'harga_perbulan' => 'decimal:0',
        ];
    }

    /**
     * Scope: available rooms
     */
    public function scopeTersedia($query)
    {
        return $query->where('status', 'tersedia');
    }

    /**
     * Check if room is available
     */
    public function isAvailable(): bool
    {
        return $this->status === 'tersedia';
    }

    /**
     * Get formatted price
     */
    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->harga_perbulan, 0, ',', '.');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'rooms_id_room');
    }

    public function booking(): HasOne
    {
        return $this->hasOne(Booking::class, 'rooms_id_room');
    }

    public function activeBooking(): HasOne
    {
        return $this->hasOne(Booking::class, 'rooms_id_room')
            ->whereIn('status', ['pending', 'confirmed']);
    }

    public function images(): HasMany
    {
        return $this->hasMany(RoomImage::class, 'rooms_id_room');
    }

    public function room_img(): HasMany
    {
        return $this->hasMany(RoomImage::class, 'rooms_id_room');
    }
}
