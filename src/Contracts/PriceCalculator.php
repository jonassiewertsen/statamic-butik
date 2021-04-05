<?php

namespace Jonassiewertsen\Butik\Contracts;

interface PriceCalculator
{
    public function __construct(ProductRepository $product, int $quantity);

    public function get(): string;

    public function total(): PriceRepository;

    public function net(): PriceContract;

    public function gross(): PriceContract;

    public function base(): PriceRepository;
}
