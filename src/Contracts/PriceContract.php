<?php

namespace Jonassiewertsen\Butik\Contracts;

interface PriceContract
{
    public function __construct(ProductRepository $product, int $quantity);

    public function get(): string;

    public function single(): PriceRepository;

    public function total(): PriceRepository;

    public function base(): PriceRepository;
}
