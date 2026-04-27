<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class refund extends Model
{
    protected $table = 'refunds';
    protected $primaryKey = 'id_refund';

    protected $fillable = [
        'reason',
        'total',
        'status',
        'refund_time',
        'payments_id_payment'
    ];

    const UPDATED_AT = null;

    public function payment() : BelongsTo
    {
        return $this->belongsTo(payment::class, 'payments_id_payment');
    }
}
