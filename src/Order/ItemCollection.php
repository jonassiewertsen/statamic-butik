<?php

namespace Jonassiewertsen\Butik\Order;

use Illuminate\Support\Collection;

class ItemCollection
{
    public Collection $items;

    public function __construct(Collection $items, $fromDatabase = false)
    {
        $this->items = collect();

        if ($fromDatabase) {
            $this->items = $items;

            return $this;
        }

        $items->map(function ($item) {
            $this->items->push(
                new Item(
                    $item->slug,
                    $item->name,
                    $item->description,
                    $item->getQuantity(),
                    $item->singlePrice(),
                    $item->totalPrice(),
                    $item->taxRate,
                    $item->totalTaxAmount(),
                )
            );
        });

        return $this;
    }
}
