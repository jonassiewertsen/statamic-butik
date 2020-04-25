<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers\PaymentGateways;

use Illuminate\Support\Collection;
use Jonassiewertsen\StatamicButik\Checkout\Customer;

interface PaymentGatewayInterface {
    public function handle(Customer $customer, Collection $items, string $totalPrice);
}
