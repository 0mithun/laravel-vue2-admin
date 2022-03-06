<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'first_name', 'last_name', 'email'
    ];


    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }


    public function getTotalAttribute()
    {
        return $this->orderItems->sum(function(OrderItem $item){
            return $item->price * $item->quantity;
        });
    }


    public function getNameAttribute()
    {
        return $this->first_name . ' '. $this->last_name;
    }
}
