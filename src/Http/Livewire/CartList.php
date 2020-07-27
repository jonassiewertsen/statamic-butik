<?php

namespace Jonassiewertsen\StatamicButik\Http\Livewire;

use Jonassiewertsen\StatamicButik\Checkout\Cart as ShoppingCart;
use Jonassiewertsen\StatamicButik\Shipping\Country;
use Livewire\Component;

class CartList extends Component
{
    public $country;

    public function mount()
    {
        $this->country = ShoppingCart::country();
    }

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
        ShoppingCart::setCountry($this->country);

        return view('butik::web.cart.cart-list', [
            'country'        => $this->country,
            'countries'      => Country::list(),
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
