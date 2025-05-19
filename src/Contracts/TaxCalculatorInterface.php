<?php

namespace Taskinbirtan\EcommerceCart\Contracts;

interface TaxCalculatorInterface
{
    public function calculate(float $amount): float;
}