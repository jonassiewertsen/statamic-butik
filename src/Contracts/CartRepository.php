<?php

namespace Jonassiewertsen\Butik\Contracts;

use Illuminate\Support\Collection;
use Jonassiewertsen\Butik\Cart\Customer;
use Jonassiewertsen\Butik\Cart\ItemCollection;
use Jonassiewertsen\Butik\Http\Responses\CartResponse;

interface CartRepository
{
    public function get(): ItemCollection;

    public function raw(): array;

    // TODO: Is the locale still needed? That may be resolved via the web middleware. We'll see
    public function add(string $slug, int $quantity = 1, string|null $locale = null): CartResponse;

    public function update(string $slug, int $quantity): CartResponse;

    public function remove(string $slug): CartResponse;

    public function clear(): CartResponse;

    public function customer(): Customer|null;

    public function count(): int;

    public function totalPrice(): PriceRepository;

    public function totalShipping(): PriceRepository;

    public function totalTaxes(): Collection;

    public function shipping(): Collection;

    public function country(): string;

    public function setCountry(string $isoCode): void;

    public function removeNonSellableItems(): void;

    public function contains(string $slug): bool;
}
