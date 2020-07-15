<?php

namespace Jonassiewertsen\StatamicButik\Http\Traits;

use Statamic\Support\Str;

trait ProductUrlTrait {
    /**
     * A Product has a edit url
     */
    public function getEditUrlAttribute()
    {
        $cp_route = config('statamic.cp.route');

        return "/{$cp_route}/butik/products/{$this->slug}/edit";
    }

    /**
     * A product has a show url
     */
    public function getShowUrlAttribute()
    {
        $route = "{$this->shopRoute()}/{$this->slug}";
        return Str::of($route)->start('/');
    }
}
