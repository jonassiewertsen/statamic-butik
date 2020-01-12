<?php

namespace Jonassiewertsen\StatamicButik\Http\Tags;

use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Statamic\Tags\Tags as StatamicTags;

class Butik extends StatamicTags
{
    public function products()
    {
         return Product::all();
    }

    public function currencySymbol()
    {
        return config('statamic-butik.currency.symbol');
    }
}
