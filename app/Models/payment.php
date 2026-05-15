<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class payment extends Model
{
    protected $table = 'payments';
    protected $primaryKey = 'id_payments';
    
    protected $fillable = [
        'payment_method',
        'payment_status',
        'payment_time',
        'bookings_id_booking'
    ];

    const CREATED_AT = 'payment_time';
    const UPDATED_AT = null;

    public function billingPenghuni() : HasOne
    {
        return $this->hasOne(billingPenghuni::class, 'payments_id_payment');
    }
    
    public function refund() : HasOne
    {
        return $this->hasOne(refund::class, 'payments_id_payment');
    }
}
