<?php

namespace Taskinbirtan\EcommerceCart\Tests\Models;

use Illuminate\Database\Eloquent\Model;

class TestProduct extends Model
{
    protected $table = 'test_products';
    protected $fillable = ['name', 'price', 'meta'];

    protected $casts = [
        'meta' => 'array',
    ];

    public function getUnitPrice(): float
    {
        return (float)$this->price;
    }

    public function getTitle(): ?string
    {
        return $this->name;
    }

    public function getMeta(): array
    {
        return $this->meta ?? [];
    }
}
