<?php

namespace Taskinbirtan\EcommerceCart\Tests;

use Orchestra\Testbench\TestCase as Base;
use Taskinbirtan\EcommerceCart\Providers\CartServiceProvider;

class TestCase extends Base
{
    protected function getPackageProviders($app): array
    {
        return [
            CartServiceProvider::class
        ];
    }

}