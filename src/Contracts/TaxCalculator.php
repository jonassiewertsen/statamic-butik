<?php

namespace Jonassiewertsen\Butik\Contracts;

interface TaxCalculator
{
    public function __construct(ProductRepository $product, int $quantity = 1, string|null $locale = null);

    public function title(): string;

    public function total(): PriceRepository;

    public function single(): PriceRepository;

    public function rate(): int;
}
