<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Session\SessionManager;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Taskinbirtan\EcommerceCart\Contracts\CartInterface;
use Taskinbirtan\EcommerceCart\Tests\Models\TestProduct;
use Taskinbirtan\EcommerceCart\Contracts\ProductResolverInterface;
use Taskinbirtan\EcommerceCart\Services\CartManager;


uses(RefreshDatabase::class);

uses(RefreshDatabase::class);

beforeEach(function () {
    config(['ecommerce-cart.product_model' => TestProduct::class]);

    Artisan::call('migrate');
    Schema::create('test_products', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->decimal('price', 10, 2);
        $table->json('meta')->nullable();
        $table->timestamps();
    });

    // seed test products
    DB::table('test_products')->insert([
        [
            'name' => 'Prod A',
            'price' => 10,
            'meta' => json_encode(['color' => 'red', 'size' => 'L']),
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'Prod B',
            'price' => 20.5,
            'meta' => json_encode(['color' => 'blue']),
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'Prod C',
            'price' => 5.25,
            'meta' => json_encode(['weight' => 100]),
            'created_at' => now(),
            'updated_at' => now(),
        ],
    ]);

    $session = $this->app->make(SessionManager::class);
    $session->put('cart_id', (string)Str::uuid());
    $resolver = $this->app->make(ProductResolverInterface::class);
    $this->cart = new CartManager($session, $resolver);
});

it('can add products to cart and calculate total', function () {
    $cart = app(CartInterface::class);

    TestProduct::all()->each(function ($product) use ($cart) {
        $cart->addItem((string)$product->id, 1, $product->meta);
    });

    expect($cart->items())->toHaveCount(3)
        ->and($cart->total())->toBe(35.75);
});

it('can add multiple different products', function () {
    /** @var \Illuminate\Support\Collection $products */
    $products = TestProduct::all();

    $first = $products->get(0);
    $second = $products->get(1);

    /** @var \Taskinbirtan\EcommerceCart\Contracts\CartInterface $cart */
    $cart = app(CartInterface::class);

    $cart->addItem((string)$first->id, 2);
    $cart->addItem((string)$second->id, 3);

    $items = $cart->items();
    $ids = array_column($items, 'item_id');

    expect($ids)->toContain((string)$first->id)
        ->and($ids)->toContain((string)$second->id);

    $expected = 2 * $first->price + 3 * $second->price;
    expect($cart->total())->toBe($expected);
});