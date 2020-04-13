<?php

namespace Jonassiewertsen\StatamicButik\Helpers;

use Illuminate\Support\Facades\Session;
use Jonassiewertsen\StatamicButik\Http\Models\Product;

class Cart {
    public function __construct()
    {
        if($this->get() === null)
            $this->set($this->empty());
    }

    public function add(Product $product): void
    {
        $cart = $this->get();
        array_push($cart['products'], $product);
        $this->set($cart);
    }

    public function remove(int $productId): void
    {
        $cart = $this->get();
        array_splice($cart['products'], array_search($productId, array_column($cart['products'], 'id')), 1);
        $this->set($cart);
    }

    public function clear(): void
    {
        $this->set($this->empty());
    }

    public function empty(): array
    {
        return [
            'products' => [],
        ];
    }

    public function get(): ?array
    {
        return Session::get('cart');
    }

    private function set($cart): void
    {
        Session::put('cart', $cart);
    }
}
