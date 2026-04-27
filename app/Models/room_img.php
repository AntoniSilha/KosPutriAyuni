<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class room_img extends Model
{
    protected $table = 'room_img';
    protected $primaryKey = 'id_image';

    protected $fillable = [
        'img_url',
        'rooms_id_room'
    ];

    const CREATED_AT = null;
    const UPDATED_AT = null;

    public function room() : BelongsTo 
    {
        return $this->belongsTo(room::class, 'rooms_id_room');
    }
}
