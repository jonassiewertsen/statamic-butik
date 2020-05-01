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
}
