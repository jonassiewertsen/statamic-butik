<?php

namespace Jonassiewertsen\StatamicButik\Http\Livewire;

use Jonassiewertsen\StatamicButik\Checkout\Cart as ShoppingCart;
use Livewire\Component;

class Cart extends Component
{
    public function getTotalPriceProperty()
    {
        return ShoppingCart::totalPrice();
    }

    public function getTotalShippingProperty()
    {
        return ShoppingCart::totalShipping();
    }

    public function render()
    {
        return view('butik::web.livewire.cart', [
            'items'          => ShoppingCart::get(),
            'total_price'    => $this->totalPrice,
            'total_shipping' => $this->totalShipping,
        ]);
    }

    public function add($slug)
    {
        ShoppingCart::add($slug);
        $this->emit('cartUpdated');
    }

    public function reduce($slug)
    {
        ShoppingCart::reduce($slug);
        $this->emit('cartUpdated');
    }
}
