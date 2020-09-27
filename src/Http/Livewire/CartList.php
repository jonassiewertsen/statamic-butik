<?php

namespace Jonassiewertsen\StatamicButik\Http\Livewire;

use Jonassiewertsen\StatamicButik\Checkout\Cart as ShoppingCart;
use Jonassiewertsen\StatamicButik\Http\Traits\MapCartItems;
use Jonassiewertsen\StatamicButik\Shipping\Country;
use Livewire\Component;

class CartList extends Component
{
    use MapCartItems;

    public $country;

    public function mount()
    {
        $this->country = ShoppingCart::country();
    }

    public function updateCountry()
    {
        ShoppingCart::setCountry($this->country);
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

    public function render()
    {
        return view('butik::web.cart.cart-list', [
            'countries'      => Country::list(),
            'items'          => $this->mappedCartItems(),
            'total_price'    => ShoppingCart::totalPrice(),
            'total_shipping' => ShoppingCart::totalShipping(),
        ]);
    }
}
