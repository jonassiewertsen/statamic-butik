<?php

namespace Jonassiewertsen\StatamicButik\Http\Livewire;

use Jonassiewertsen\StatamicButik\Checkout\Cart;
use Facades\Jonassiewertsen\StatamicButik\Http\Models\Product;
use Livewire\Component;

class ProductVariantSection extends Component
{
    public $variantTitle;
    public $variantData;
    public $product;

    public function mount($product): void
    {
        $this->product      = (array) Product::find($product['slug']);
        $this->variantTitle = request()->segment(3);
    }

    public function addToCart()
    {
        Cart::add($this->variantData['slug']);
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

        return view('butik::web.components.product-variant-section', [
            'price'               => $this->variantData['price'],
            'variant_title'       => $this->variantData['title'],
            'variant_short_title' => $this->variantData['original_titl'] ?? null,
            'stock'               => $this->variantData['stock'],
            'stock_unlimited'     => $this->variantData['stock_unlimited'],
            'slug'                => $this->variantData['slug'],
            'product'             => (array) $this->variantData,
        ]);
    }

    protected function productData()
    {
//        if ($this->product->hasVariants()) {
//            /** check if exists, otherwise we
//             * will use the parents product data
//             */
//            return $this->product->getVariant($this->variantTitle);
//        }

        return $this->product;
    }
}
