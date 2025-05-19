<?php

namespace Taskinbirtan\EcommerceCart\Contracts;

interface CartItemPayloadInterface
{
    public function getId(): string;

    public function getUnitPrice(): float;

    public function getTitle(): ?string;

    public function getMeta(): array;
}