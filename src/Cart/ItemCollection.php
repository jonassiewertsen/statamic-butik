<?php

namespace Jonassiewertsen\Butik\Cart;

use Illuminate\Support\Collection;

class ItemCollection extends Collection
{
    public function items(array $items): self
    {
        foreach ($items as $slug => $value) {
            $this->push(new Item($slug, $value['quantity']));
        }

        return $this;
    }
}
