<?php

namespace Jonassiewertsen\StatamicButik\Checkout;

use Illuminate\Support\Collection;
use Jonassiewertsen\StatamicButik\Http\Models\Product;

class Cart {
    public ?Customer $customer;
    public ?Collection $products;
    public ?Transaction $transaction;
    public ?string $amount; // TODO: To string or not to string?

    public function __construct()
    {
        // TODO: Move calculation from Product model to Cart object.
    }

    public function customer(Customer $customer): self {
        $this->customer = $customer;
        return $this;
    }

    public function transaction(Transaction $transaction): self {
        $this->transaction = $transaction;
        return $this;
    }

    public function addProduct(Product $product): self {
        if (empty($this->products)) {
            $this->products = collect();
        }
        $this->products->push($product);

        return $this;
    }
}
