<?php

namespace Jonassiewertsen\Butik\Repositories;

use Jonassiewertsen\Butik\Support\ButikEntry;
use Jonassiewertsen\Butik\Contracts\ShippingRepository as ShippingRepositoryContract;

class ShippingRepository extends ButikEntry implements ShippingRepositoryContract
{
    public function collection(): string
    {
        return 'butik_shippings'; // TODO: Get from config
    }

    public function toArray(): array
    {
        return []; // TODO: Implement
    }
}
