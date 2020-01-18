<?php

namespace Jonassiewertsen\StatamicButik\Http\PaymentGateways;

use Illuminate\Http\Request;
use Braintree_Gateway;
use Jonassiewertsen\StatamicButik\Http\Controllers\WebController;

class BraintreePaymentGateway extends WebController implements PaymentGatewayInterface
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
        // TODO: Passing the amount like this is shit !!! SECURITY ....
        $amount = $payload['amount'] ?? 40;
        // TODO: What THE Fu .... get it done!

        $response = $this->braintree->transaction()->sale([
            'amount' => $amount,
            'paymentMethodNonce' => $nonce,
            'options' => [ 'submitForSettlement' => true ]
        ]);

        return $response;
    }
}
