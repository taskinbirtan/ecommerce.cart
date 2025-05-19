<?php

namespace Taskinbirtan\EcommerceCart\Contracts;

use Illuminate\Support\Collection;
use Taskinbirtan\EcommerceCart\Values\CartTotals;

interface ProductResolverInterface
{
    public function resolve(string $id): CartItemPayloadInterface;

}