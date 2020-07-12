<?php

namespace Jonassiewertsen\StatamicButik\Http\Livewire;

use Jonassiewertsen\StatamicButik\Checkout\Cart;
use Livewire\Component;

class ProductVariantSection extends Component
{
    public $product;
    public $variantTitle;
    public $variantData;

    public function mount($product): void
    {
        $this->product      = $product;
        $this->variantTitle = request()->segment(3);
    }

    public function addToCart()
    {
        Cart::add($this->variantData->slug);
        $this->emit('cartUpdated');
    }

    public function variant($slug)
    {
        $this->variantTitle = $slug;
        $this->emit('urlChange', $slug);
    }

    public function render()
    {
        $this->variantData = $this->productData();

        return view('butik::web.livewire.product-variant-section', [
            'price'                => $this->variantData->price,
            'express_delivery_url' => $this->variantData->express_delivery_url,
            'variant_title'        => $this->variantData->title,
            'variant_short_title'  => $this->variantData->original_title,
            'stock'                => $this->variantData->stock,
            'stock_unlimited'      => $this->variantData->stock_unlimited,
            'slug'                 => $this->variantData->slug,
        ]);
    }

    protected function productData()
    {
        if ($this->product->hasVariants()) {
            /** check if exists, otherwise we
             * will use the parents product data
             */
            return $this->product->getVariant($this->variantTitle);
        }

        return $this->product;
    }
}
