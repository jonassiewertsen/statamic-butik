<?php

namespace Jonassiewertsen\StatamicButik\Http\Middleware;

use Closure;
use Jonassiewertsen\StatamicButik\Helper\Cart;

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
