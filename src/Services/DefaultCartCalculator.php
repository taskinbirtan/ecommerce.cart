<?php

namespace Taskinbirtan\EcommerceCart\Services;

use Taskinbirtan\EcommerceCart\Contracts\CartCalculatorInterface;
use Taskinbirtan\EcommerceCart\Contracts\TaxCalculatorInterface;
use Taskinbirtan\EcommerceCart\Values\CartTotals;
use Illuminate\Support\Collection;

class DefaultCartCalculator implements CartCalculatorInterface
{
    protected TaxCalculatorInterface $taxCalculator;

    public function __construct(
        TaxCalculatorInterface $taxCalculator
    )
    {
        $this->taxCalculator = $taxCalculator;
    }

    public function calculate(Collection $items): CartTotals
    {
        $subtotal = $items->sum(fn($item) => $item->price * $item->quantity);
        $discount = 0;
        $tax = $this->taxCalculator->calculate($subtotal - $discount);
        $total = $subtotal - $discount + $tax;

        return new CartTotals($subtotal, $discount, $tax, $total);
    }
}