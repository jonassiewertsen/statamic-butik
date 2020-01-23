<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers\Web;

use Illuminate\Http\Request;
use Jonassiewertsen\StatamicButik\Http\Controllers\WebController;
use Illuminate\Support\Facades\Session;
use Jonassiewertsen\StatamicButik\Http\Controllers\PaymentGateways\MolliePaymentGateway;

class PaymentGatewayController extends WebController
{
    protected $gateway;

    public function __construct()
    {
        $this->gateway = new MolliePaymentGateway();
    }

    public function processPayment()
    {
        // TODO: Duplicated line fragments. Fine for now, refactor later
        $cart = session()->get('butik.cart');

        if ($cart === null || $cart->products === null || $cart->products->count() > 1) {
            return redirect()->route('butik.shop');
        }

        if ($cart->products->first()->soldOut || ! $cart->products->first()->available) {
            return redirect($cart->products->first()->showUrl);
        }

        if (! $this->customerDataComplete()) {
            return redirect($cart->products->first()->ExpressDeliveryUrl);
        }

        $cart = Session::get('butik.cart');
        return $this->gateway->handle($cart);
    }

    public function webhook(Request $request): void {
        $this->gateway->webhook($request);
    }
}
