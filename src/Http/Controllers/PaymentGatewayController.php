<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers;

use Illuminate\Http\Request;
use Jonassiewertsen\StatamicButik\Http\PaymentGateways\BraintreePaymentGateway;

class PaymentGatewayController extends Controller
{
    protected $gateway;

    public function __construct()
    {
        $this->gateway = new BraintreePaymentGateway();
    }

    public function processPayment(Request $request) {
        $response = $this->gateway->handle($request);

        if ($response->success) {
            return redirect()->route('butik.payment.receipt');
        }

        return response()->json($response);
    }
}
