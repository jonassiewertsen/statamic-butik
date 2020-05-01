<?php

namespace Jonassiewertsen\StatamicButik\Http\Middleware;

use Closure;
use Jonassiewertsen\StatamicButik\Helper\Cart;

class UpdateCart
{
    public function handle($request, Closure $next)
    {
        Cart::update();

        return $next($request);
    }
}
