<?php

namespace Jonassiewertsen\Butik\Http\Middleware;

use Closure;
use Jonassiewertsen\Butik\Checkout\Cart;

class CartNotEmpty
{
    public function handle($request, Closure $next)
    {
        if (Cart::totalItems() === 0) {
            return redirect()->route('butik.cart');
        }

        return $next($request);
    }
}
