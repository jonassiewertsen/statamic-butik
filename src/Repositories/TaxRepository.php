<?php

namespace Jonassiewertsen\Butik\Repositories;

use Jonassiewertsen\Butik\Contracts\CountryRepository;
use Jonassiewertsen\Butik\Contracts\TaxRepository as TaxRepositoryContract;
use Jonassiewertsen\Butik\Support\ButikEntry;

class TaxRepository extends ButikEntry implements TaxRepositoryContract
{
    public function __construct(
        public CountryRepository $country,
    ) {}

    public function rate(): float
    {
        return (float) $this->data['rate'];
    }

    public function collection(): string
    {
        return 'butik_taxes';
    }

    public function toArray(): array
    {
        return []; // TODO: Needs implementation
    }
}
