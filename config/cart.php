<?php

return [
    /**
     * Fully qualified class name of the Eloquent model
     * or any class implementing resolvable interface for items.
     */
    'product_model' => env('CART_PRODUCT_MODEL', Taskinbirtan\EcommerceCart\Tests\Models\TestProduct::class),
    'tax_rate' => env('CART_TAX_RATE', 0.18),
];