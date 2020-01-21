<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers\Web;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Jonassiewertsen\StatamicButik\Events\PaymentSuccessful;
use Jonassiewertsen\StatamicButik\Http\Controllers\WebController;
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

    public function processPayment(Request $request)
    {
        return $this->gateway->handle();
    }

    public function webhook(Request $request): void {
        $this->gateway->webhook($request);
    }
}
