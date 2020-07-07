<?php

namespace Jonassiewertsen\StatamicButik\Http\Livewire;

use Livewire\Component;

class ProductVariantSection extends Component
{
    public $product;
    public $varianttitle;

    protected $variantData;

    public function mount($product): void
    {
        $this->product      = $product;
        $this->varianttitle = request()->segment(3);
    }

    public function variant($slug)
    {
        $this->varianttitle = $slug;
        $this->emit('urlChange', $slug);
    }

    protected function productData()
    {
        if ($this->product->hasVariants()) {
            /** check if exists, otherwise we
             * will use the parents product data
             */
            return $this->product->getVariant($this->varianttitle);
        }

        return $this->product;
    }

    public function render()
    {
        $this->variantData = $this->productData();

        return view('butik::web.livewire.product-variant-section', [
            'price'               => $this->variantData->price,
            'variant_title'       => $this->variantData->title,
            'variant_short_title' => $this->variantData->original_title,
            'stock'               => $this->variantData->stock,
            'stock_unlimited'     => $this->variantData->stock_unlimited,
        ]);
    }
}
