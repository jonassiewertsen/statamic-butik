<?php

namespace Jonassiewertsen\Butik\Item;

use Jonassiewertsen\Butik\Facades\Product;
use Jonassiewertsen\Butik\Support\ButikEntry;

class Item
{
    public string $slug;
    public int $quantity;
    public ButikEntry $product; // TODO: Is the butik entry the correct class?

    public function __construct(string $slug, int $quantity)
    {
        $this->slug = $slug;
        $this->product = Product::find($slug);
        $this->quantity = $quantity;
    }
}
