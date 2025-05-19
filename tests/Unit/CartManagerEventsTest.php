<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Session\SessionManager;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Taskinbirtan\EcommerceCart\Events\ItemAdded;
use Taskinbirtan\EcommerceCart\Events\ItemUpdated;
use Taskinbirtan\EcommerceCart\Events\ItemRemoved;
use Taskinbirtan\EcommerceCart\Events\CartCleared;
use Taskinbirtan\EcommerceCart\Contracts\ProductResolverInterface;
use Taskinbirtan\EcommerceCart\Services\CartManager;

uses(RefreshDatabase::class);

beforeEach(function () {
    Artisan::call('migrate');
    Schema::create('test_products', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->decimal('price', 10, 2);
        $table->json('meta')->nullable();
        $table->timestamps();
    });

    DB::table('test_products')->insert([
        [
            'id' => 1,
            'name' => 'Test Ürün 1',
            'price' => 10.00,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'id' => 2,
            'name' => 'Test Ürün 2',
            'price' => 15.00,
            'created_at' => now(),
            'updated_at' => now(),
        ],
    ]);

    // Session & CartManager setup
    $session = $this->app->make(SessionManager::class);
    $session->put('cart_id', (string)Str::uuid());

    $resolver = $this->app->make(ProductResolverInterface::class);
    $this->cart = new CartManager($session, $resolver);
});

it('dispatches ItemAdded when adding a new item', function () {
    Event::fake([ItemAdded::class]);

    $this->cart->addItem('1', 1);

    Event::assertDispatched(ItemAdded::class, function (ItemAdded $event) {
        return $event->item->item_id === '1'
            && $event->item->quantity === 1;
    });
});

it('dispatches ItemUpdated when updating quantity via updateQuantity', function () {
    $this->cart->addItem('1', 1);
    Event::fake([ItemUpdated::class]);

    $this->cart->updateQuantity('1', 5);

    Event::assertDispatched(ItemUpdated::class, function (ItemUpdated $e) {
        return $e->item->item_id === '1' && $e->item->quantity === 5;
    });
});

it('dispatches ItemRemoved when updateQuantity reduces to zero', function () {
    $this->cart->addItem('1', 1);
    Event::fake([ItemRemoved::class]);

    $this->cart->updateQuantity('1', 0);

    Event::assertDispatched(ItemRemoved::class);
});

it('dispatches ItemRemoved when calling removeItem', function () {
    $this->cart->addItem('1', 2);
    Event::fake([ItemRemoved::class]);

    $this->cart->removeItem('1');

    Event::assertDispatched(ItemRemoved::class);
});

it('dispatches CartCleared when calling clear', function () {
    $this->cart->addItem('1', 1);
    $this->cart->addItem('2', 1);
    Event::fake([CartCleared::class]);

    $this->cart->clear();

    Event::assertDispatched(CartCleared::class);
});