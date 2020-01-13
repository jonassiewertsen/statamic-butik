<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers;

use Illuminate\Http\Request;
use Braintree_Gateway;

class PaymentGatewayController extends Controller
{
    protected $gateway;

    public function __construct()
    {
        require_once __DIR__.'/../../../vendor/braintree/braintree_php/lib/Braintree.php';

        $this->gateway = new Braintree_Gateway([
            'environment' => 'sandbox',
            'merchantId' => '8t2hkkd3nn7yqncp',
            'publicKey' => 'j3txsgnhkx8q4cdp',
            'privateKey' => '020f0a4c1d7db142d33e40c04f9a4799'
        ]);
    }

    public function handle(Request $request) {
        $payload = $request->input('payload', false);
        $nonce = $payload['nonce'];
        $amount = $payload['amount'];

        $status = $this->gateway->transaction()->sale([
            'amount' => $amount,
            'paymentMethodNonce' => $nonce,
            'options' => [ 'submitForSettlement' => true ]
        ]);

        return response()->json($status);
    }
}
