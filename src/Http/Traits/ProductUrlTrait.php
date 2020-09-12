<?php

namespace Jonassiewertsen\StatamicButik\Http\Traits;

use Statamic\Support\Str;

trait ProductUrlTrait {
    /**
     * A product has a show url
     */
    public static function showUrl(string $slug)
    {
        $route = config('butik.route_shop-prefix') . '/' . $slug;
        return Str::of($route)->start('/');
    }
}
