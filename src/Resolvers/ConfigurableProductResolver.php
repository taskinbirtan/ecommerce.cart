<?php

namespace Taskinbirtan\EcommerceCart\Resolvers;

use Taskinbirtan\EcommerceCart\Contracts\CartItemPayloadInterface;
use Taskinbirtan\EcommerceCart\Contracts\ProductResolverInterface;
use Taskinbirtan\EcommerceCart\Models\CartItemPayload;

class ConfigurableProductResolver implements ProductResolverInterface
{
    public function resolve(string $id): CartItemPayloadInterface
    {
        $modelClass = config('cart.product_model');
        $modelInstance = (new $modelClass)->findOrFail($id);

        foreach (['getKey', 'getUnitPrice', 'getTitle', 'getMeta'] as $method) {
            if (!method_exists($modelInstance, $method)) {
                throw new \RuntimeException("Model [{$modelClass}] must implement method {$method}().");
            }
        }

        return new CartItemPayload(
            (string) $modelInstance->getKey(),
            $modelInstance->getUnitPrice(),
            $modelInstance->getTitle(),
            $modelInstance->getMeta()
        );
    }
}