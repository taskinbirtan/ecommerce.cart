<?php

namespace Taskinbirtan\EcommerceCart\Events;

use Taskinbirtan\EcommerceCart\Models\CartItem;

class ItemAdded
{
    public CartItem $item;

    public function __construct(CartItem $item)
    {
        $this->item = $item;
    }
}