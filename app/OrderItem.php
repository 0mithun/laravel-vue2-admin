<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id', 'product_title', 'price', 'quantity'
    ];


    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
