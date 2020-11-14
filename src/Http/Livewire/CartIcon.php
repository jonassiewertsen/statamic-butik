<?php

namespace Jonassiewertsen\StatamicButik\Http\Livewire;

use Jonassiewertsen\StatamicButik\Checkout\Cart as ShoppingCart;
use Livewire\Component;

class CartIcon extends Component
{
    protected $listeners = [
        'cartUpdated' => '$refresh',
    ];

    public function getTotalProperty()
    {
        return ShoppingCart::totalItems();
    }

    public function render()
    {
        return view('butik::web.components.cart-icon', [
            'total' => $this->total,
        ]);
    }
}
