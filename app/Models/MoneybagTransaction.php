<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MoneybagTransaction extends Model
{
    protected $fillable = [
        'order_id',
        'checkout_id',
        'transaction_id',
        'status',
        'amount',
        'currency',
        'request_data',
        'response_data',
        'payment_completed_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'request_data' => 'array',
        'response_data' => 'array',
        'payment_completed_at' => 'datetime',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}