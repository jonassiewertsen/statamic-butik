<?php

namespace Jonassiewertsen\StatamicButik\Http\Livewire;

use Jonassiewertsen\StatamicButik\Helpers\Cart as ShoppingCart;
use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Livewire\Component;

class Cart extends Component
{
    public function getTotalProperty()
    {
        $total['price'] = ShoppingCart::totalPrice();
        return $total;
    }

    public function render()
    {
        return view('butik::web.livewire.cart', [
            'items' => ShoppingCart::get(),
            'total' => $this->total,
        ]);
    }

    public function add($slug)
    {
        $product = Product::find($slug);
        ShoppingCart::add($product);
    }

    public function reduce($slug)
    {
        $product = Product::find($slug);
        ShoppingCart::reduce($product);
    }
}