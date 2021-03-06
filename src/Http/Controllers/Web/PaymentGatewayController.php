<?php

namespace Jonassiewertsen\Butik\Http\Controllers\Web;

use Illuminate\Http\Request;
use Jonassiewertsen\Butik\Checkout\Cart;
use Jonassiewertsen\Butik\Exceptions\ButikConfigException;
use Jonassiewertsen\Butik\Http\Controllers\PaymentGateways\PaymentGatewayInterface;
use Jonassiewertsen\Butik\Http\Controllers\WebController;

class PaymentGatewayController extends WebController
{
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
        $items = Cart::get();
        $customer = Cart::customer();
        $shippings = Cart::shipping();
        $totalPrice = Cart::totalPrice();

        return $this->gateway->handle($customer, $items, $totalPrice, $shippings);
    }

    public function webhook(Request $request): void
    {
        $this->gateway->webhook($request);
    }
}
