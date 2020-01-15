<?php

namespace Jonassiewertsen\StatamicButik\Http\Tags;

use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Statamic\Tags\Tags as StatamicTags;

class Braintree extends StatamicTags
{
    public function route() {
        $name = $this->getParam(['name']);

        switch ($name) {
            case 'payment.process':
                return route("butik.{$name}");
                break;
            default:
                return null;
        }
    }
}
