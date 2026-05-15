<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Refund extends Model
{
    protected $table = 'refunds';
    protected $primaryKey = 'id_refund';

    protected $fillable = [
        'reason',
        'total',
        'status',
        'refund_time',
        'payments_id_payment',
    ];

    const UPDATED_AT = null;

    protected function casts(): array
    {
        return [
            'total' => 'decimal:0',
            'refund_time' => 'datetime',
        ];
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class, 'payments_id_payment');
    }
}
