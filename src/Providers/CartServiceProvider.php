<?php

namespace Taskinbirtan\EcommerceCart\Providers;

use Illuminate\Support\ServiceProvider;
use Taskinbirtan\EcommerceCart\Contracts\CartInterface;
use Taskinbirtan\EcommerceCart\Contracts\ProductResolverInterface;
use Taskinbirtan\EcommerceCart\Contracts\TaxCalculatorInterface;
use Taskinbirtan\EcommerceCart\Resolvers\ConfigurableProductResolver;
use Taskinbirtan\EcommerceCart\Services\CartManager;
use Taskinbirtan\EcommerceCart\Services\DefaultTaxCalculator;

class CartServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(
            TaxCalculatorInterface::class, DefaultTaxCalculator::class
        );
        $this->publishes([
            __DIR__ . '/../../config/cart.php' => config_path('cart.php')
        ], 'cart-config');

        $this->mergeConfigFrom(
            __DIR__ . '/../../config/cart.php', 'cart'
        );

        $this->app->singleton(CartInterface::class, fn($app) => new CartManager(
            $app->make('session'),
            $app->make(ProductResolverInterface::class)
        ));
        $this->app->singleton(ProductResolverInterface::class, ConfigurableProductResolver::class);
        $this->app->alias(CartManager::class, 'cart');
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
    }
}