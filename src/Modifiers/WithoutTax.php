<?php

namespace Jonassiewertsen\StatamicButik\Modifiers;

use Facades\Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Http\Traits\MoneyTrait;
use Statamic\Modifiers\Modifier;

class WithoutTax extends Modifier
{
    use MoneyTrait;

    public function index($values, $params, $context)
    {
        $product = Product::find($context['slug']);

        $price = $this->makeAmountSaveable($product->price);
        $taxAmount = $this->makeAmountSaveable($product->tax_amount);

        return $this->makeAmountHuman($price - $taxAmount);
    }
}
