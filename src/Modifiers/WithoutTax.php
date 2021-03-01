<?php

namespace Jonassiewertsen\StatamicButik\Modifiers;

use Facades\Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Facades\Price;
use Statamic\Modifiers\Modifier;

class WithoutTax extends Modifier
{
    public function index($values, $params, $context)
    {
        $product = Product::find($context['slug']);

        return Price::of($product->price)
            ->substract($product->tax_amount)
            ->get();
    }
}
