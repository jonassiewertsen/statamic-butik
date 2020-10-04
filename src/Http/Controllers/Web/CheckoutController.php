<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Jonassiewertsen\StatamicButik\Checkout\Customer;
use Jonassiewertsen\StatamicButik\Checkout\Cart;
use Jonassiewertsen\StatamicButik\Http\Models\Order;
use Jonassiewertsen\StatamicButik\Http\Traits\MapCartItems;
use Jonassiewertsen\StatamicButik\Shipping\Country;
use Statamic\View\View as StatamicView;

class CheckoutController extends Checkout
{
    use MapCartItems;

    public function delivery()
    {
        $customer = session()->has('butik.customer') ?
            Session::get('butik.customer') :
            (new Customer())->empty();

        return (new StatamicView())
           ->template(config('butik.template_checkout-delivery'))
           ->layout(config('butik.layout_checkout-delivery'))
           ->with([
                'customer'         => (array) $customer,
                'countries'        => Country::list(),
                'selected_country' => Cart::country(),
                'items'            => $this->mappedCartItems(),
            ]);
    }

    public function storeCustomerData()
    {
        $validatedData = request()->validate($this->rules());

        $customer = new Customer($validatedData);
        Session::put('butik.customer', $customer);

        if ($validatedData['country'] !== Cart::country()) {
            Cart::setCountry($validatedData['country']);
            return redirect()->back();
        }

        return redirect()->route('butik.checkout.payment');
    }

    public function payment()
    {
        Cart::removeNonSellableItems();

        return (new StatamicView())
            ->template(config('butik.template_checkout-payment'))
            ->layout(config('butik.layout_checkout-payment'))
            ->with([
                'customer'       => (array) session('butik.customer'),
                'items'          => $this->mappedCartItems(),
            ]);
    }

    public function receipt(Request $request, $order)
    {
        if (! $request->hasValidSignature()) {
            return $this->showInvalidReceipt();
        }

        if (! $order = Order::firstWhere('number', $order)) {
            return $this->showInvalidReceipt();
        }

        if ($order->status === 'paid') {
            Session::forget('butik.customer');
            Cart::clear();
        }

        return (new StatamicView())
            ->template(config('butik.template_checkout-receipt'))
            ->layout(config('butik.layout_checkout-receipt'))
            ->with([
                'customer' => (array) $order->customer,
                'order'    => $order->toArray(),
            ]);
    }
}
