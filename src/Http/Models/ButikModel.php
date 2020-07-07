<?php

namespace Jonassiewertsen\StatamicButik\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Jonassiewertsen\StatamicButik\Http\Traits\MoneyTrait;

abstract class ButikModel extends Model {
    use MoneyTrait;

    /**
     * The route to the base shop
     */
    protected function shopRoute()
    {
        return config('butik.route_shop-prefix');
    }
}
