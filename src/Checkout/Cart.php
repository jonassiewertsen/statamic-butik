<?php

namespace Jonassiewertsen\StatamicButik\Checkout;

use Illuminate\Support\Collection;
use Jonassiewertsen\StatamicButik\Http\Models\Product;

class Cart {
    public ?Customer $customer;
    public ?Collection $items;
    public ?Transaction $transaction;
    public ?string $amount; // TODO: To string or not to string?

    public function __construct()
    {
        // TODO: Move calculation from Product model to Cart object.
    }

    public function add(Product $product): self {
        // TODO: Add a new product if not exisiting.
        // If existing, increase the amount of the product
        if (empty($this->items)) {
            $this->items = collect();
        }

        $this->items->push(new Item($product));

        return $this;
    }

    public function remove(Product $product): self {
        // TODO: Remove a single product from the shopping cart
    }

    public function clear(): void {
        // TODO: Clear the complete shopping cart
    }

    public function customer(Customer $customer): self {
        $this->customer = $customer;
        return $this;
    }

    public function transaction(Transaction $transaction): self {
        $this->transaction = $transaction;
        return $this;
    }


}
