<?php

namespace Jonassiewertsen\StatamicButik\Modifiers;

use Statamic\Modifiers\Modifier;

class Sellable extends Modifier
{
    public function index($value, $params, $context)
    {
        return ! $value->contains('sellable', false);
    }
}
