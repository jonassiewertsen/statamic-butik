<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers\Web;

use Illuminate\Http\Request;
use Jonassiewertsen\StatamicButik\Http\Controllers\PaymentGateways\PaymentGatewayInterface;
use Jonassiewertsen\StatamicButik\Http\Controllers\WebController;
use Jonassiewertsen\StatamicButik\Http\Controllers\PaymentGateways\MolliePaymentGateway;

class PaymentGatewayController extends WebController
{
    protected PaymentGatewayInterface $gateway;

    public function __construct()
    {
        $this->gateway = new MolliePaymentGateway();
    }

    public function processPayment()
    {
        $cart = session()->get('butik.cart');

        return $this->gateway->handle($cart);
    }

    public function webhook(Request $request): void {
        $this->gateway->webhook($request);
    }
}
