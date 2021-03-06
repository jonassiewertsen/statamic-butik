<?php

namespace Jonassiewertsen\Butik\Http\Controllers\PaymentGateways;

use Illuminate\Support\Collection;
use Jonassiewertsen\Butik\Checkout\Customer;

interface PaymentGatewayInterface
{
    public function handle(Customer $customer, Collection $items, string $totalPrice, Collection $shippings);
}
