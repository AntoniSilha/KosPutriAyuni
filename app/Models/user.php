<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Booking;

class User extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id_user';

    protected $fillable = [
        'no_ktp',
        'name',
        'email',
        'password',
        'no_hp',
        'role'
    ];

    protected $hidden = [
        'password'
    ];

    const UPDATED_AT = null; 

    public function booking(): HasOne
    {
        return $this->hasOne(Booking::class, 'users_id_user');
    }
}