<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers\Web;

use Illuminate\Http\Request;
use Jonassiewertsen\StatamicButik\Http\Controllers\WebController;
use Illuminate\Support\Facades\Session;
use Jonassiewertsen\StatamicButik\Http\Controllers\PaymentGateways\MolliePaymentGateway;

class PaymentGatewayController extends WebController
{
    protected $gateway;

    // TODO: Only available products can be bought
    // TODO: Only proceed if stock available

    public function __construct()
    {
        $this->gateway = new MolliePaymentGateway();
    }

    public function processPayment()
    {
        $cart = Session::get('butik.cart'); // TODO: check if exists
        return $this->gateway->handle($cart);
    }

    public function webhook(Request $request): void {
        $this->gateway->webhook($request);
    }
}
