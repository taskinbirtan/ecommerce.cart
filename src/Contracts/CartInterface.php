<?php

namespace Taskinbirtan\EcommerceCart\Contracts;

interface CartInterface
{
    public function addItem(string $itemId, int $quantity = 1, array $options = []): void;
    public function removeItem(string $itemId): void;
    public function updateQuantity(string $itemId, int $quantity): void;
    public function clear(): void;
    public function items(): array;
    public function total(): float;
}