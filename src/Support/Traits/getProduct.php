<?php

namespace Jonassiewertsen\Butik\Support\Traits;

use Jonassiewertsen\Butik\Contracts\ProductRepository;
use Jonassiewertsen\Butik\Exceptions\ButikProductException;
use Jonassiewertsen\Butik\Facades\Product;
use Statamic\Facades\Blink;

trait getProduct
{
    protected function getProduct(mixed $identifier): ?ProductRepository
    {
        if ($identifier instanceof ProductRepository) {
            return $identifier;
        }

        if (gettype($identifier) === 'string') {
            $product = Blink::once("butik.product.{$identifier}", fn () => Product::findBySlug($identifier));

            throw_unless($product, new ButikProductException("The product with the Slug of '{$identifier}' does not exist."));

            return $product;
        }

        $type = gettype($identifier);
        throw new ButikCartException("The given Type of '{$type}' is invalid to return any kind of product.");
    }
}
