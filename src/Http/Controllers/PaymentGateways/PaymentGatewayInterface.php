<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers\PaymentGateways;

use Jonassiewertsen\StatamicButik\Checkout\Cart;

interface PaymentGatewayInterface {
    public function handle(Cart $cart);
}
