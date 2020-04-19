<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Jonassiewertsen\StatamicButik\Checkout\Customer;
use Jonassiewertsen\StatamicButik\Http\Models\Order;
use Jonassiewertsen\StatamicButik\Http\Models\Product;

class ExpressCheckoutController extends Checkout
{
    public function delivery(Product $product)
    {
        $customer = session()->has('butik.customer') ?
                    Session::get('butik.customer') :
                    (new Customer())->empty();

        return view(config('butik.template_express-checkout-delivery'), compact('customer', 'product'));
    }

    public function saveCustomerData(Product $product)
    {
        $customer = request()->validate($this->rules());

        $customer = new Customer($customer);

        Session::put('butik.customer', $customer);

        return redirect()->route('butik.checkout.express.payment', $product);
    }

    public function payment(Product $product)
    {
        $customer = session('butik.customer');

        return view(config('butik.template_express-checkout-payment'), compact('customer', 'product'));
    }

    public function receipt(Request $request, $order)
    {
        if (!$request->hasValidSignature()) {
           return $this->showInvalidReceipt();
        }

        if (! $order = Order::find($order))
        {
            return $this->showInvalidReceipt();
        }

        $customer = json_decode($order->customer);

        if ($order->status === 'paid') {
            Session::forget('butik.customer');
        }

        return view(config('butik.template_checkout-receipt'), compact('customer', 'order'));
    }

    private function transactionSuccessful()
    {
        return session()->has('butik.transaction.success')
            && session()->get('butik.transaction.success') === true;
    }

    private function transactionDataComplete()
    {
        $keys = [
            'success',
            'id',
            'type',
            'currencyIsoCode',
            'amount',
            'created_at',
            'customer',
        ];
        foreach ($keys as $key) {
            if (!session()->has("butik.transaction.{$key}")) {
                return false;
            }
        }

        return true;
    }

    private function showInvalidReceipt() {
        return view(config('butik.template_checkout-receipt-invalid'));
    }
}
