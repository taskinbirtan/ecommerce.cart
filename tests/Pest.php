<?php

namespace Taskinbirtan\EcommerceCart\Tests;

uses(TestCase::class)->beforeEach(function () {
    $this->app['config']->set('cart.product_model', \Taskinbirtan\EcommerceCart\Tests\Models\TestProduct::class);
})->in(__DIR__);


