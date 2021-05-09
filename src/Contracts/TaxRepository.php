<?php

namespace Jonassiewertsen\Butik\Contracts;

interface TaxRepository
{
    public function __construct(CountryRepository $country);

    public function rate(): float | int;

    public function type(): string;

    public function for(ProductRepository $product, string | null $locale = null): TaxRepository | null;
}
