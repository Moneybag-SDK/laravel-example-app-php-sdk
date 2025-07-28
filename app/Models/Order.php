<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'customer_name',
        'customer_email',
        'customer_phone',
        'shipping_address',
        'city',
        'state',
        'zipcode',
        'country',
        'total_amount',
        'payment_status',
        'payment_reference',
        'moneybag_transaction_id',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function moneybagTransactions(): HasMany
    {
        return $this->hasMany(MoneybagTransaction::class);
    }
}