<?php

namespace Jonassiewertsen\StatamicButik\Http\Livewire;

use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Livewire\Component;

class ProductVariantSection extends Component
{
    public $product;
    public $variant;

    protected $variantData;
    protected $updatesQueryString = ['variant'];

    public function mount($product): void
    {
        $this->product = $product;
        $this->variant = request()->query('variant', $this->variant);
    }

    public function variant($slug)
    {
        $this->variant = $slug;
    }

    public function render()
    {
        $this->variantData = $this->productData();

        return view('butik::web.livewire.product-variant-section', [
            'price'           => $this->variantData->price,
            'title'           => $this->variantData->title,
            'stock'           => $this->variantData->stock,
            'stock_unlimited' => $this->variantData->stock_unlimited,
        ]);
    }

    protected function productData()
    {
        if ($this->product->hasVariants()) {
            return $this->product->getVariant($this->variant);
        }

        return $this->product;
    }
}
