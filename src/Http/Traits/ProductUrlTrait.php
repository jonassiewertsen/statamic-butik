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
        return "{$this->shopRoute()}/{$this->slug}";
    }

    /**
     * A product has a express delivery checkout url
     */
    public function getExpressDeliveryUrlAttribute()
    {
        $checkout = config('butik.uri.checkout.express.delivery');

        return "{$this->shopRoute()}/{$checkout}/{$this->slug}";
    }
}