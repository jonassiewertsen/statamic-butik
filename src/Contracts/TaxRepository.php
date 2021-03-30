<?php

namespace Jonassiewertsen\Butik\Contracts;

interface TaxRepository
{
    public function __construct(CountryRepository $country);

    public function rate(): float;
}
