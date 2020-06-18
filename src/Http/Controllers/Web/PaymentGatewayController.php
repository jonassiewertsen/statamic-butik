<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Jonassiewertsen\StatamicButik\Checkout\Item;
use Jonassiewertsen\StatamicButik\Checkout\Cart;
use Jonassiewertsen\StatamicButik\Http\Controllers\PaymentGateways\PaymentGatewayInterface;
use Jonassiewertsen\StatamicButik\Http\Controllers\WebController;
use Jonassiewertsen\StatamicButik\Http\Controllers\PaymentGateways\MolliePaymentGateway;
use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Http\Traits\MoneyTrait;

class PaymentGatewayController extends WebController
{
    use MoneyTrait;

    protected PaymentGatewayInterface $gateway;

    public function __construct()
    {
        $this->gateway = new MolliePaymentGateway();
    }

    public function processPayment()
    {
        $customer   = Session::get('butik.customer');
        $items      = Session::get('butik.cart');
        $totalPrice = $this->humanPriceWithDot(Cart::totalPrice());

        return $this->gateway->handle($customer, $items, $totalPrice);
    }

    public function processExpressPayment(Product $product)
    {
        $customer   = Session::get('butik.customer');
        $item       = new Item($product);
        $totalPrice = $this->humanPriceWithDot($item->totalPrice());

        $items = collect()->push($item);

        return $this->gateway->handle($customer, $items, $totalPrice);
    }

    public function webhook(Request $request): void {
        $this->gateway->webhook($request);
    }
}
