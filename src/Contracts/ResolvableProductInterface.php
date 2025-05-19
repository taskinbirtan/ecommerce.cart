<?php

namespace Taskinbirtan\EcommerceCart\Contracts;

interface ResolvableProductInterface
{
    /**
     * Get unique identifier for cart
     */
    public function getKey(): string;

    /**
     * Get price as float
     */
    public function getUnitPrice(): float;

    /**
     * Get title or name
     */
    public function getTitle(): ?string;

    /**
     * Get additional metadata as array
     */
    public function getMeta(): array;
}