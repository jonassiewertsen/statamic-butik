<?php

namespace Jonassiewertsen\StatamicButik\Http\Middleware;

use Closure;
use Jonassiewertsen\StatamicButik\Checkout\Customer;
use Jonassiewertsen\StatamicButik\Http\Models\Product;

class ValidateExpressCheckoutRoute
{
    public function handle($request, Closure $next)
    {
        if (! $productSlug = $request->segment(4)) {
            dd('1');
            return redirect()->route('butik.shop');
        }

        $product = Product::findOrFail($productSlug);

        if ($product->soldOut || ! $product->available) {
            dd('2');
            return redirect($product->showUrl);
        }

        if (! session()->has('butik.customer') ) {
            dd('3');
            return redirect()->route('butik.shop');
        }

        $customer = session()->get('butik.customer');

        if (! $this->customerDataComplete($customer)) {
            dd('4');
            return redirect($product->ExpressDeliveryUrl);
        }

        return $next($request);
    }

    private function customerDataComplete(Customer $customer): bool {
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
