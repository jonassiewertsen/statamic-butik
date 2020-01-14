<?php

namespace Jonassiewertsen\StatamicButik\Http\PaymentGateways;

use Illuminate\Http\Request;
use Braintree_Gateway;
use Jonassiewertsen\StatamicButik\Http\Controllers\Controller;

class BraintreePaymentGateway extends Controller implements PaymentGatewayInterface
{
    protected $braintree;

    public function __construct()
    {
        require_once __DIR__.'/../../../vendor/braintree/braintree_php/lib/Braintree.php';

        $this->braintree = new Braintree_Gateway([
            'environment' => config('statamic-butik.payment.braintree.env'),
            'merchantId' => config('statamic-butik.payment.braintree.merchant_id'),
            'publicKey' => config('statamic-butik.payment.braintree.public_key'),
            'privateKey' => config('statamic-butik.payment.braintree.private_key'),
        ]);
    }

    public function handle(Request $request) {
        $payload = $request->input('payload', false);
        $nonce = $payload['nonce'];
        $amount = $payload['amount'];

        $status = $this->braintree->transaction()->sale([
            'amount' => $amount,
            'paymentMethodNonce' => $nonce,
            'options' => [ 'submitForSettlement' => true ]
        ]);

        return response()->json($status);
    }
}
