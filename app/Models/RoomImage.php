<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class RoomImage extends Model
{
    protected $table = 'room_img';
    protected $primaryKey = 'id_image';

    public $timestamps = false;

    protected $fillable = [
        'img_url',
        'rooms_id_room',
    ];

    /**
     * Accessor: resolve img_url to a full, publicly accessible URL.
     *
     * Handles three cases:
     * 1. Already a full URL (http/https) → return as-is
     * 2. Relative path stored by FileUpload (e.g. "rooms/abc.jpg") → build URL via Storage disk
     * 3. Empty/null → return null
     *
     * This ensures the URL works both locally and in production
     * (e.g. when using S3 or any cloud disk, just change the 'public' disk config).
     */
    public function getImgUrlAttribute($value): ?string
    {
        if (empty($value)) {
            return null;
        }

        // If it's already a full URL, return as-is
        if (str_starts_with($value, 'http://') || str_starts_with($value, 'https://')) {
            return $value;
        }

        // Otherwise build a public URL from the storage disk
        return Storage::disk('public')->url($value);
    }

    /**
     * Get the raw database value without the accessor
     * (needed by Filament FileUpload to correctly populate the field)
     */
    public function getRawImgUrl(): ?string
    {
        return $this->attributes['img_url'] ?? null;
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class, 'rooms_id_room');
    }
}
