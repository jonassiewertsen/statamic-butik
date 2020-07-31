<?php

namespace Jonassiewertsen\StatamicButik\Modifiers;

use Jonassiewertsen\StatamicButik\Shipping\Country;
use Statamic\Modifiers\Modifier;

class CountryName extends Modifier
{
    public function index($value)
    {
        return Country::getName($value) ?: $value;
    }
}
