<?php

namespace Taskinbirtan\EcommerceCart\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = [
        'cart_id',
        'item_id',
        'quantity',
        'unit_price',
        'options',
    ];

    protected $casts = [
        'options' => 'array',
    ];

    public function getPriceAttribute(): float
    {
        return $this->unit_price;
    }
}