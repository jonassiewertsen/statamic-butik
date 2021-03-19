<?php

namespace Jonassiewertsen\Butik\Http\Middleware;

use Closure;
use Jonassiewertsen\Butik\Cart\Customer;

class ValidateCheckoutRoute
{
    public function handle($request, Closure $next)
    {
        $customer = session()->get('butik.customer');

        if (! $this->customerDataComplete($customer)) {
            return redirect(route('butik.checkout.delivery'));
        }

        return $next($request);
    }

    private function customerDataComplete(?Customer $customer): bool
    {
        if ($customer === null) {
            return false;
        }

        $keys = collect(['firstname', 'surname', 'email', 'country', 'address1', 'city', 'zip']);

        foreach ($keys as $key) {
            // Return false in case one of the keys does not exist inside the session data
            if (empty($customer->$key)) {
                return false;
            }
        }

        return true;
    }
}
