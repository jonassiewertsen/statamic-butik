<?php

namespace Jonassiewertsen\StatamicButik\Checkout;

use Illuminate\Support\Collection;
use Jonassiewertsen\StatamicButik\Http\Models\Product;

class Order {
    public ?Customer $customer;
    public ?Collection $products;
    public ?Transaction $transaction;
    public ?string $amount; // TODO: Set type hint

    public function __construct()
    {
        // TODO: Calculate amount automatically
    }

    public function getId(): string {
        return $this->transaction->id;
    }

    public function customer(Customer $customer): self {
        $this->customer = $customer;
        return $this;
    }

    public function transaction(Transaction $transaction): self {
        $this->transaction = $transaction;
        return $this;
    }

    public function products(Collection $products): self {
        $this->products = $products;
        return $this;
    }

    public function addProduct(Product $product): self {
        if ($this->products->count() === 0) {
            collect($this->products);
        }
        $this->products->push($product);
    }
}