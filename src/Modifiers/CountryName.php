<?php

namespace Jonassiewertsen\Butik\Modifiers;

use Jonassiewertsen\Butik\Shipping\Country;
use Statamic\Modifiers\Modifier;

class CountryName extends Modifier
{
    public function index($values)
    {
        return Country::getName($values) ?: $values;
    }
}
