<?php

namespace Jonassiewertsen\Butik\Fieldtypes;

use Jonassiewertsen\Butik\Contracts\TaxCalculator;
use Jonassiewertsen\Butik\Facades\Product;
use Statamic\Fields\Fieldtype;

class Tax extends Fieldtype
{
    protected $icon       = 'tags';
    protected $categories = ['butik'];
    protected $selectable = false;

    public function preload()
    {
        return [
            'types' => $this->types(),
        ];
    }

    public function augment($value): array
    {
        $tax = $this->getTax();

        return [
            'title' => $tax->title(),          // {{ tax:title }}
            'type' => $value,                  // {{ tax:type }}
            'amount' => $tax->single()->get(), // {{ tax:amount }}
            'rate' => $tax->rate(),            // {{ tax:rate }}
        ];
    }

    public function process($data)
    {
        return $data;
    }

    public function preProcess($data)
    {
        return $data;
    }

    public function preProcessIndex($data)
    {
        return $data;
    }

    private function types(): array
    {
        return collect(config('butik.tax_types', []))
            ->flatMap(fn ($label, $value) => [compact('label', 'value')])
            ->toArray();
    }

    private function getTax(): TaxCalculator
    {
        $productId = $this->field()->parent()->id();
        $product = Product::find($productId);

        return $product->tax();
    }
}
