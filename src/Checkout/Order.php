<?php

namespace Jonassiewertsen\StatamicButik\Checkout;

use Illuminate\Support\Collection;
use Jonassiewertsen\StatamicButik\Http\Models\Product;

class Order {
    public $customer;
    public $products;
    public $transaction;
    public $amount;

    public function __construct()
    {
        // TODO: Calculate amount automatically
    }

    public function getId() {
        return $this->transaction->id;
    }

    public function customer(Customer $customer) {
        $this->customer = $customer;
        return $this;
    }

    public function transaction(Transaction $transaction) {
        $this->customer = $transaction;
        return $this;
    }

    public function products(Collection $products) {
        $this->customer = $products;
        return $this;
    }

    public function addProduct(Product $product) {
        if ($this->products->count() === 0) {
            collect($this->products);
        }
        $this->products->push($product);
    }
}