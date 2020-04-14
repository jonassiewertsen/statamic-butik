<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers\Web;

use Illuminate\Http\Request;
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

//    public function processPayment(Product $product)
//    {
//        $customer = session()->get('butik.customer');
//
//        return $this->gateway->handle($cart);
//    }

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
