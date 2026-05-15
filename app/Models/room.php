<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class room extends Model
{
    protected $table = 'rooms';
    protected $primaryKey = 'id_room';
    
    protected $fillable = [
        'no_kamar',
        'deskripsi',
        'harga_perbulan',
        'status'
    ];

    const CREATED_AT = null;
    const UPDATED_AT = null;

    public function booking() : HasOne
    {
        return $this->hasOne(booking::class, 'rooms_id_room');
    }

    public function room_img() : HasMany
    {
        return $this->hasMany(room_img::class, 'rooms_id_room');
    }
}
