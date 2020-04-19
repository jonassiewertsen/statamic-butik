<?php

namespace Jonassiewertsen\StatamicButik\Http\Middleware;

use Closure;
use Jonassiewertsen\StatamicButik\Checkout\Customer;
use Jonassiewertsen\StatamicButik\Http\Models\Product;

class ValidateCheckoutRoute
{
    public function handle($request, Closure $next)
    {
//        if ($product->soldOut || ! $product->available) {
//            return redirect($product->showUrl);
//        }
//
//        if (! session()->has('butik.customer') ) {
//            return redirect()->route('butik.shop');
//        }

        $customer = session()->get('butik.customer');

        if (! $this->customerDataComplete($customer)) {
            return redirect(route('butik.checkout.delivery'));
        }

        return $next($request);
    }

    private function customerDataComplete(?Customer $customer): bool {
        if ($customer === null)
        {
            return false;
        }

        $keys = collect(['name', 'mail', 'country', 'address1', 'city', 'zip']);

        foreach ($keys as $key) {
            // Return false in case one of the keys does not exist inside the session data
            if (empty($customer->$key)) {
                return false;
            }
        }

        return true;
    }
}
