<?php

use Taskinbirtan\EcommerceCart\Services\DefaultTaxCalculator;

it('calculates tax correctly for positive amounts', function () {
    $calculator = new DefaultTaxCalculator(0.20);

    expect($calculator->calculate(10.00))->toBe(2.00)
        ->and($calculator->calculate(27.50))->toBe(5.50);
});

it('returns zero for zero or negative amounts', function () {
    $calculator = new DefaultTaxCalculator(0.18);

    expect($calculator->calculate(0.00))->toBe(0.00)
        ->and($calculator->calculate(-5.00))->toBe(0.00);
});