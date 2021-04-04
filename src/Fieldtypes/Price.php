<?php

namespace Jonassiewertsen\Butik\Fieldtypes;

use Jonassiewertsen\Butik\Contracts\ProductRepository;
use Jonassiewertsen\Butik\Facades;
use Jonassiewertsen\Butik\Facades\Product;
use Statamic\Fields\Fieldtype;

class Price extends Fieldtype
{
    protected $categories = ['butik'];
    protected $selectable = false;
    protected $icon = 'tags';

    public function preload()
    {
        return [
            'currencySymbol' => currency(),
            'priceDefault' => config('butik.price', 'gross'),
        ];
    }

    public function process($data)
    {
        return $data;
    }

    public function preProcess($data)
    {
        return Facades\Price::of($data)->delimiter('.')->thousands('')->get();
    }

    public function augment($value): array
    {
        $product = $this->getProduct();

        return [
            'gross' => $product->price->gross()->get(), // {{ price:gross }}
            'net' => $product->price->net()->get(),     // {{ price:net }}
            'total' => $product->price->get(),          // {{ price:total }}
            'raw' => $value,                            // {{ price:raw }}
        ];
    }

    private function getProduct(): ProductRepository
    {
        $productId = $this->field()->parent()->id();

        return Product::find($productId);
    }
}
