<?php

namespace Taskinbirtan\EcommerceCart\Services;

use Taskinbirtan\EcommerceCart\Contracts\TaxCalculatorInterface;

class DefaultTaxCalculator implements TaxCalculatorInterface
{
    /**
     * Vergi oranı (örn. 0.18 -> %18)
     *
     * @var float
     */
    protected float $rate;

    public function __construct(
        $rate = null
    )
    {
        $this->rate = $rate ?? config('cart.tax_rate', 0.20);
    }

    /**
     * @inheritDoc
     */
    public function calculate(float $amount): float
    {
        if ($amount <= 0) {
            return 0.0;
        }
        return round($amount * $this->rate, 2);
    }
}