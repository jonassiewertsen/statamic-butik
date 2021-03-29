<?php

namespace Jonassiewertsen\Butik\Http\Middleware;

use Closure;
use Jonassiewertsen\Butik\Cart\Cart;

class UpdateCart
{
    public function handle($request, Closure $next)
    {
        Cart::update();

        return $next($request);
    }
}
