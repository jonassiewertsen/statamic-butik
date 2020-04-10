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
            return redirect($cart->items->first()->product->ExpressDeliveryUrl);
        }

        if ($cart === null || $cart->items === null || $cart->items->count() > 1) {
            return redirect()->route('butik.shop');
        }

        if ($cart->items->first()->product->soldOut || !$cart->items->first()->product->available) {
            return redirect($cart->items->first()->product->showUrl);
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
