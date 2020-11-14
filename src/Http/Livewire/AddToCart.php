<?php

namespace Jonassiewertsen\StatamicButik\Http\Livewire;

use Jonassiewertsen\StatamicButik\Checkout\Cart;
use Livewire\Component;

class AddToCart extends Component
{
    public $slug;
    public $redirect;
    public $locale;

    public function mount($slug, $redirect = null)
    {
        $this->slug = $slug;
        $this->locale = locale();
        $this->redirect = $redirect;
    }

    public function add()
    {
        Cart::add($this->slug, $this->locale);
        $this->emit('cartUpdated');

        if ($this->redirect) {
            return redirect(route('butik.cart'));
        }
    }

    public function render()
    {
        return view('butik::web.components.add-to-cart');
    }
}
