<?php

namespace Jonassiewertsen\StatamicButik\Contracts;

use Illuminate\Support\Collection;
use Jonassiewertsen\StatamicButik\Checkout\Customer;

interface CartRepository
{
    public function get(): Collection;

    public function add(string $slug, int $quantity = 1, ?string $locale = null): void;

    public function reduce($slug): void;

    public function remove($slug): void;

    public function clear(): void;

    public static function customer(): ?Customer;

    public function count(): int;

    public function totalPrice(): string;

    public function totalShipping(): string;

    public function totalTaxes(): Collection;

    public function shipping(): Collection;

    public function country(): string;

    public function setCountry(string $code): void;

    public function removeNonSellableItems(): void;

    public function contains(string $slug): bool;
}
