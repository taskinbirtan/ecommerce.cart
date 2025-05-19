<?php

namespace Taskinbirtan\EcommerceCart\Contracts;

use Illuminate\Support\Collection;
use Taskinbirtan\EcommerceCart\Values\CartTotals;

interface CartCalculatorInterface
{
    public function calculate(Collection $items): CartTotals;
}