<?php

namespace Jonassiewertsen\StatamicButik\Http\Middleware;

use Closure;
use Jonassiewertsen\StatamicButik\Http\Models\Product;

class ValidateExpressCheckoutRoute
{
    public function handle($request, Closure $next)
    {
        if (! $productSlug = $request->segment(4)) {
            return redirect()->route('butik.shop');
        }

        $product = Product::findOrFail($productSlug);

        if ($product->soldOut || ! $product->available) {
            return redirect($product->showUrl);
        }

        if (! session()->has('butik.cart') ) {
            return redirect()->route('butik.shop');
        }

        $cart = session()->get('butik.cart');

        if (! $this->customerDataComplete($cart)) {
            return redirect($product->ExpressDeliveryUrl);
        }

        return $next($request);
    }

    private function customerDataComplete($cart): bool {
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
