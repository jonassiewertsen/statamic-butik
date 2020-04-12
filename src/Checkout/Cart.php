<?php

namespace Jonassiewertsen\StatamicButik\Checkout;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Jonassiewertsen\StatamicButik\Http\Models\Product;

class Cart {
    public ?Customer    $customer;
    public ?Collection  $items;
    public ?Transaction $transaction;

    public function get(): self
    {
        $this->items = collect();

        if (Session::has('butik.cart')) {
            $items = Session::get('butik.cart');

            foreach($items as $item) {
                $this->items->push((array) $item);
            }
        }

        return $this;
    }

    public function add(Product $product): self {
        $this->items->push(new Item($product));

        Session::put('butik.cart', $this->items);

        return $this;
    }

    public function remove(Product $product): self {
        $this->items = $this->items->reject(function($item) use ($product) {
           return $item->id === $product->slug;
        });

        return $this;
    }

    public function customer(Customer $customer): self {
        $this->customer = $customer;
        return $this;
    }

    public function transaction(Transaction $transaction): self {
        $this->transaction = $transaction;
        return $this;
    }

//    Todo: May it be removed?
//    /**
//     * Is the shopping cart empty?
//     */
//    private function cartEmpty(): bool
//    {
//        return empty($this->items);
//    }

//    TODO: May it be removed?
//    /**
//     * @param Product $product
//     * @return bool
//     */
//    private function contains(Product $product): bool
//    {
//        return $this->items->contains('id', $product->slug);
//    }
}
