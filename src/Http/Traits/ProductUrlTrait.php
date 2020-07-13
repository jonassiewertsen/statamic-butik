<?php

namespace Jonassiewertsen\StatamicButik\Http\Traits;

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
        return "/{$this->shopRoute()}/{$this->slug}";
    }
}
