<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class booking extends Model
{
    protected $table = 'bookings';
    protected $primaryKey = 'id_booking';

    protected $fillable = [
        'invoice_number',
        'check_in',
        'status',
        'rooms_id_room',
        'users_id_user'
    ];

    const UPDATED_AT = null;

    public function user() : BelongsTo 
    {
        return $this->belongsTo(user::class, 'users_id_user');
    }

    public function room() : BelongsTo
    {
        return $this->belongsTo(room::class, 'rooms_id_room');
    }

    public function payment() : HasOne
    {
        return $this->hasOne(payment::class, 'bookings_id_booking');
    }
}
