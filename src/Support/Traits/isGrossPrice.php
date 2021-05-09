<?php

namespace Jonassiewertsen\Butik\Support\Traits;

trait isGrossPrice
{
    protected function isGrossPrice(): bool
    {
        return config('butik.price', 'gross') === 'gross';
    }
}
