<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers\Web;

use Illuminate\Support\Facades\Session;
use Jonassiewertsen\StatamicButik\Checkout\Customer;
use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Http\Models\Variant;

class ExpressCheckoutController extends Checkout
{
    public function delivery(Product $product, $variant = null)
    {
        $product = $this->defineProductData($product, $variant);

        $customer = session()->has('butik.customer') ?
            Session::get('butik.customer') :
            (new Customer())->empty();

        return view(config('butik.template_express-checkout-delivery'), compact('customer', 'product'));
    }

    public function saveCustomerData(Product $product, $variant = null)
    {
        $customer = request()->validate($this->rules());

        $customer = new Customer($customer);

        Session::put('butik.customer', $customer);

        return redirect()->route('butik.checkout.express.payment', ['product' => $product, 'variant' => $variant]);
    }

    public function payment(Product $product, $variant = null)
    {
        $customer = session('butik.customer');
        $product  = $this->defineProductData($product, $variant);

        return view(config('butik.template_express-checkout-payment'), compact('customer', 'product'));
    }

    private function defineProductData(Product $product, $variant)
    {
        if ($variant) {
            if (! $product->variantExists($variant)) {
                abort(404);
            }

            return $product->getVariant($variant);
        }

        return $product;
    }
}
