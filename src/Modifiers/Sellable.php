<?php

namespace Jonassiewertsen\Butik\Modifiers;

use Statamic\Modifiers\Modifier;

class Sellable extends Modifier
{
    public function index($values, $params, $context)
    {
        foreach ($values as $value) {
            if ($value['sellable'] === false) {
                return false;
            }
        }

        /**
         * Only returning true if none of the items has
         * been flagged as non sellable.
         */
        return true;
    }
}
