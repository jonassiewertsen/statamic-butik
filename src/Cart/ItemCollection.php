<?php

namespace Jonassiewertsen\Butik\Cart;

use Illuminate\Support\Collection;

class ItemCollection extends Collection
{
    public function __construct(array $items)
    {
        foreach ($items as $slug => $value) {
            $this->push(new Item($slug, $value['quantity']));
        }
    }
}
