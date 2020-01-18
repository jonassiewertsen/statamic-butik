<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers\Web;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Jonassiewertsen\StatamicButik\Events\PaymentSuccessful;
use Jonassiewertsen\StatamicButik\Http\Controllers\Controller;
use Jonassiewertsen\StatamicButik\Http\PaymentGateways\BraintreePaymentGateway;

class PaymentGatewayController extends Controller
{
    protected $gateway;

    public function __construct()
    {
        $this->gateway = new BraintreePaymentGateway();
    }

    public function processPayment(Request $request)
    {
        $response = $this->gateway->handle($request);
        if ($response->success) {
            $this->saveTransactionInSession($response);
            event(new PaymentSuccessful($response->transaction));
        }

        return response()->json($response);
    }

    private function saveTransactionInSession($response) {
        $customer = session()->pull('butik.customer');

        Session::put(
            'butik.transaction', collect([
                // TODO: save the product slug as well
                'success'         => $response->success,
                'id'              => $response->transaction->id,
                'type'            => $response->transaction->type,
                'currencyIsoCode' => $response->transaction->currencyIsoCode,
                'amount'          => $response->transaction->amount,
                'created_at'      => Carbon::parse($response->transaction->createdAt),
                'customer'        => $customer,
            ]));
    }
}