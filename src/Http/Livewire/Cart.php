<?php

namespace Jonassiewertsen\StatamicButik\Http\Livewire;

use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Livewire\Component;

class Cart extends Component
{
    public function mount(): void
    {
        //
    }

    public function render()
    {
        return view('butik::web.livewire.cart');
    }
}
