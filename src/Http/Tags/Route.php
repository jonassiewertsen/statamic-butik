<?php

namespace Jonassiewertsen\StatamicButik\Http\Tags;

use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Statamic\Tags\Tags as StatamicTags;

class Route extends StatamicTags
{
    // TODO: To kepp or not?

    public function widlcard($tag) {
        switch($tag) {
            case 'checkout.express.delivery':
                return route('butik.'.$tag, ['product' => $this->getParam('slug')]);
                break;
            case 'checkout.express.payment':
                return route('butik.'.$tag, ['product' => $this->getParam('slug')]);
                break;
        }
    }
   // {{ route:express.delivery slug=""
}
