<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BillingPenghuni extends Model
{
    protected $table = 'billingPenghuni';
    protected $primaryKey = 'id_billing'; //data private untuk keamanan data

    public $timestamps = false;

    protected $fillable = [
        'jatuh_tempo',
        'payments_id_payment',
    ];

    protected function casts(): array
    {
        return [
            'jatuh_tempo' => 'date',
        ];
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class, 'payments_id_payment');
    }
}
