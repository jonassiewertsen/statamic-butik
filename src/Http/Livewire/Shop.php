<?php

namespace Jonassiewertsen\StatamicButik\Http\Livewire;

use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Livewire\Component;

class Shop extends Component
{
    public $search;

    protected $updatesQueryString = ['search'];

    public function mount(): void
    {
        $this->search = request()->query('search', $this->search);
    }

    public function render()
    {
        return view('butik::web.livewire.shop', [
            'products' => Product::where('title', 'like', '%' . $this->search . '%')->get()
        ]);
    }
}
