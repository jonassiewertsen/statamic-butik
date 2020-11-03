<?php

namespace Jonassiewertsen\StatamicButik\Modifiers;

use Jonassiewertsen\StatamicButik\Shipping\Country;
use Statamic\Modifiers\Modifier;

class CountryName extends Modifier
{
    public function index($values)
    {
        return Country::getName($values) ?: $values;
    }
}
