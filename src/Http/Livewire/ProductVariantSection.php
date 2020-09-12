<?php

namespace Jonassiewertsen\StatamicButik\Http\Livewire;

use Jonassiewertsen\StatamicButik\Checkout\Cart;
use Facades\Jonassiewertsen\StatamicButik\Http\Models\Product;
use Livewire\Component;

class ProductVariantSection extends Component
{
    public    $variantTitle;
    public    $variantData;
    protected $product;

    public function mount($product): void
    {
        $this->product      = Product::find($product->slug);
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
        return view('butik::web.components.product-variant-section',
            $this->variantData = $this->productData(),
        );
    }

    protected function productData()
    {
        if ($this->product->hasVariants()) {
            /** check if exists, otherwise we
             * will use the parents product data
             */
            return $this->product->getVariant($this->variantTitle);
        }

        $product = $this->product;

        return [
            'price'               => $product->price,
            'variant_title'       => $product->title,
            'variant_short_title' => $product->original_title ?? null,
            'stock'               => $product->stock,
            'stock_unlimited'     => $product->stock_unlimited,
            'slug'                => $product->slug,
            'product'             => $product,
        ];

    }
}
