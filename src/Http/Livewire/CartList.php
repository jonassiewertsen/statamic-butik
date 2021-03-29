<?php

namespace Jonassiewertsen\Butik\Http\Livewire;

use Jonassiewertsen\Butik\Cart\Cart as ShoppingCart;
use Jonassiewertsen\Butik\Http\Traits\MapCartItems;
use Jonassiewertsen\Butik\Shipping\Country;
use Livewire\Component;

class CartList extends Component
{
    use MapCartItems;

    public $country;
    public $locale;

    public function mount()
    {
        $this->locale = locale();
        $this->country = ShoppingCart::country();
    }

    public function updateCountry()
    {
        ShoppingCart::setCountry($this->country);
    }

    public function add($slug)
    {
        ShoppingCart::add($slug, $this->locale);
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
            'total_taxes'    => ShoppingCart::totalTaxes(),
        ]);
    }
}
