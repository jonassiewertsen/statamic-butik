<?php

namespace Jonassiewertsen\Butik\Http\Traits;

trait isGrossPrice
{
    protected function isGrossPrice(): bool
    {
        return config('butik.price', 'gross') === 'gross';
    }
}
