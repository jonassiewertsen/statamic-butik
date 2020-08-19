<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Jonassiewertsen\StatamicButik\Checkout\Cart;
use Jonassiewertsen\StatamicButik\Exceptions\ButikConfigException;
use Jonassiewertsen\StatamicButik\Http\Controllers\PaymentGateways\PaymentGatewayInterface;
use Jonassiewertsen\StatamicButik\Http\Controllers\WebController;
use Jonassiewertsen\StatamicButik\Http\Traits\MoneyTrait;

class PaymentGatewayController extends WebController
{
    use MoneyTrait;

    protected PaymentGatewayInterface $gateway;

    public function __construct()
    {
        $paymentGateway = config('butik.payment_gateway');

        if (! class_exists($paymentGateway)) {
            throw new ButikConfigException('Your payment gateway class as defined in you config file could not be found');
        }

        $this->gateway = new $paymentGateway();
    }

    public function processPayment()
    {
        $customer   = Session::get('butik.customer');
        $items      = Session::get('butik.cart');
        $shippings  = Cart::shipping();
        $totalPrice = $this->humanPriceWithDot(Cart::totalPrice());

        return $this->gateway->handle($customer, $items, $totalPrice, $shippings);
    }

    public function webhook(Request $request): void {
        $this->gateway->webhook($request);
    }
}
