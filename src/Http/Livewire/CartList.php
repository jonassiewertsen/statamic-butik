<?php

namespace Jonassiewertsen\StatamicButik\Http\Livewire;

use Jonassiewertsen\StatamicButik\Checkout\Cart as ShoppingCart;
use Jonassiewertsen\StatamicButik\Http\Models\Country;
use Livewire\Component;

class CartList extends Component
{
    public $countrySlug;

    public function mount()
    {
        $this->countrySlug = ShoppingCart::country()['slug'];
    }

    public function getCountryProperty()
    {
        ShoppingCart::setCountry($this->countrySlug);
        return $this->countrySlug;
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
            'country'        => $this->country,
            'countries'      => Country::pluck('name', 'slug'),
            'items'          => ShoppingCart::get(),
            'total_price'    => ShoppingCart::totalPrice(),
            'total_shipping' => ShoppingCart::totalShipping(),
        ]);
    }
}
