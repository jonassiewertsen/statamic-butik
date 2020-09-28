<?php

namespace Jonassiewertsen\StatamicButik\Http\Livewire;

use Jonassiewertsen\StatamicButik\Checkout\Cart;
use Livewire\Component;

class AddToCart extends Component
{
    public $slug;

    public function mount($slug)
    {
        $this->slug = $slug;
    }

    public function add()
    {
        Cart::add($this->slug);
        $this->emit('cartUpdated');
    }

    public function render()
    {
        return view('butik::web.components.add-to-cart');
    }
}
