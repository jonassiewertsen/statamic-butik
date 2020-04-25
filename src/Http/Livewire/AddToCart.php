<?php

namespace Jonassiewertsen\StatamicButik\Http\Livewire;

use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Helper\Cart;
use Livewire\Component;

class AddToCart extends Component
{
    public $product;

    public function mount($product)
    {
        $this->product = $product;
    }

    public function render()
    {
        return view('butik::web.livewire.add-to-cart');
    }

    public function addToCart($productSlug)
    {
        $product = Product::find($productSlug);
        Cart::add($product);
        $this->emit('cartUpdated');
    }
}
