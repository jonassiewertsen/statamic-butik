<?php

namespace Jonassiewertsen\StatamicButik\Http\Models;

use Illuminate\Database\Eloquent\Model;

abstract class ButikModel extends Model
{
    /**
     * The route to the base shop.
     */
    protected static function shopRoute()
    {
        return config('butik.route_shop-prefix');
    }
}
