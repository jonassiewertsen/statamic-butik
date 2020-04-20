<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Jonassiewertsen\StatamicButik\Checkout\Item;
use Jonassiewertsen\StatamicButik\Http\Controllers\PaymentGateways\PaymentGatewayInterface;
use Jonassiewertsen\StatamicButik\Http\Controllers\WebController;
use Jonassiewertsen\StatamicButik\Http\Controllers\PaymentGateways\MolliePaymentGateway;
use Jonassiewertsen\StatamicButik\Http\Models\Product;

class PaymentGatewayController extends WebController
{
    protected PaymentGatewayInterface $gateway;

    public function __construct()
    {
        $this->gateway = new MolliePaymentGateway();
    }

    public function processPayment()
    {
        $customer   = Session::get('butik.customer');
        $items      = Session::get('butik.cart');

        return $this->gateway->handle($customer, $items);
    }

    public function processExpressPayment(Product $product)
    {
        $customer = session()->get('butik.customer');

        $items = collect();
        $items->push(new Item($product));

        return $this->gateway->handle($customer, $items);
    }

    public function webhook(Request $request): void {
        $this->gateway->webhook($request);
    }
}
