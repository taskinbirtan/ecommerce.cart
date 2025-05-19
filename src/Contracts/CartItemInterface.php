<?php

namespace Taskinbirtan\EcommerceCart\Contracts;

interface CartItemInterface
{
    public function getProductId(): string;
    public function getQuantity(): int;
    public function getOptions(): array;
    public function lineTotal(): float;
}