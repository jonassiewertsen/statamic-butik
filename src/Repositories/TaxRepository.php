<?php

namespace Jonassiewertsen\Butik\Repositories;

use Jonassiewertsen\Butik\Contracts\CountryRepository;
use Jonassiewertsen\Butik\Contracts\ProductRepository;
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

    public function type(): string
    {
        return $this->data['type'];
    }

    public function for(ProductRepository $product, ?string $locale = null): TaxRepositoryContract
    {
        $locale = $locale ?? $this->country->iso();

        $tax = $this->query()
            ->get()
            // Filter for entries matching the locale.
            ->filter(function ($tax) use ($locale) {
                return in_array($locale, $tax->get('countries'));
            })
            // FIlter for entries matching the tax type.
            -> filter(function ($tax) use ($product) {
                return $tax->type === $product->tax_type;
            })
            ->first();

        return $this->find($tax->id());
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
