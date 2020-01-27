<?php

namespace Jonassiewertsen\StatamicButik\Http\Middleware;

use Closure;

class ValidateCheckoutCart
{
    public function handle($request, Closure $next)
    {
        if (! session()->has('butik.cart') ) {
            return redirect()->route('butik.shop');
        }

        $cart = session()->get('butik.cart');

        if (! $this->customerDataComplete($cart)) {
            return redirect($cart->products->first()->ExpressDeliveryUrl);
        }

        if ($cart === null || $cart->products === null || $cart->products->count() > 1) {
            return redirect()->route('butik.shop');
        }

        if ($cart->products->first()->soldOut || !$cart->products->first()->available) {
            return redirect($cart->products->first()->showUrl);
        }

        return $next($request);
    }

    protected function customerDataComplete($cart): bool {
        $keys = collect(['name', 'mail', 'country', 'address1', 'city', 'zip']);

        foreach ($keys as $key) {
            // Return false in case one of the keys does not exist inside the session data
            if (empty($cart->customer->$key)) {
                return false;
            }
        }

        return true;
    }
}