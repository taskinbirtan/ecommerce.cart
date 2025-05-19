<?php

namespace Taskinbirtan\EcommerceCart\Models;

use Illuminate\Database\Eloquent\Model;
use Taskinbirtan\EcommerceCart\Contracts\CartItemPayloadInterface;

class CartItemPayload implements CartItemPayloadInterface
{
    protected string $id;
    protected float $unitPrice;
    protected ?string $title;
    protected array $meta;

    public function __construct(string $id, float $unitPrice, ?string $title = null, array $meta = [])
    {
        $this->id = $id;
        $this->unitPrice = $unitPrice;
        $this->title = $title;
        $this->meta = $meta;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getUnitPrice(): float
    {
        return $this->unitPrice;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getMeta(): array
    {
        return $this->meta;
    }
}