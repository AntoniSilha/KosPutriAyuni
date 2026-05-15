<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class billingPenghuni extends Model
{
    protected $table = 'billingPenghuni';
    protected $primaryKey = 'id_billing';
    
    protected $fillable = [
        'jatuh_tempo',
        'payments_id_payment'
    ];
        
    const CREATED_AT = null;
    const UPDATED_AT = null;

    public function payment() : BelongsTo
    {
        return $this->belongsTo(payment::class, 'payments_id_payment');
    }
}
