<?php

namespace Jonassiewertsen\Butik\Contracts;

use Illuminate\Support\Collection;
use Jonassiewertsen\Butik\Cart\Customer;

interface CartRepository
{
    public function get(): Collection;

    public function raw(): array;

    // TODO: Is the locale still needed? That may be resolved via the web middleware. We'll see
    public function add(string $slug, int $quantity = 1, string|null $locale = null): void;

    public function reduce(string $slug): void;

    public function update(string $slug, int $quantity): void;

    public function remove(string $slug): void;

    public function clear(): void;

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
