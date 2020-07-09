<?php

namespace Jonassiewertsen\StatamicButik\Http\Livewire;

use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Livewire\Component;

class Shop extends Component
{
    public $search;

    public function render()
    {
        return view('butik::web.livewire.shop', [
            'products' => Product::all(),
        ]);
    }
}
