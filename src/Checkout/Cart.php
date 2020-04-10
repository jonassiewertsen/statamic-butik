<?php

namespace Jonassiewertsen\StatamicButik\Checkout;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Jonassiewertsen\StatamicButik\Http\Models\Product;

class Cart {
    public ?Customer    $customer;
    public ?Collection  $items;
    public ?Transaction $transaction;
    public ?string      $amount; // TODO: To string or not to string?

    public function __construct()
    {
        if ($this->cartEmpty()) {
            $this->items = collect();
        }
    }

    public function add(Product $product): self {


        if ($this->contains($product))
        {
            $this->items->firstWhere('id', $product->slug)->increase();
        } else {
            $this->items->push(new Item($product));
        }

        Session::put('butik.cart', $this);

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

    /**
     * Is the shopping cart empty?
     */
    private function cartEmpty(): bool
    {
        return empty($this->items);
    }

    /**
     * @param Product $product
     * @return bool
     */
    private function contains(Product $product): bool
    {
        return $this->items->contains('id', $product->slug);
    }


}
