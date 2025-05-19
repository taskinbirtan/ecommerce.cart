<?php

namespace Taskinbirtan\EcommerceCart\Values;

class CartTotals
{
    public float $subtotal;
    public float $discount;
    public float $tax;
    public float $total;

    public function __construct(float $subtotal, float $discount, float $tax, float $total)
    {
        $this->subtotal  = $subtotal;
        $this->discount  = $discount;
        $this->tax       = $tax;
        $this->total     = $total;
    }
}