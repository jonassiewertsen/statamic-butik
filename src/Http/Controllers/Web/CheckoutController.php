<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Jonassiewertsen\StatamicButik\Checkout\Customer;
use Jonassiewertsen\StatamicButik\Checkout\Cart;
use Jonassiewertsen\StatamicButik\Http\Models\Country;
use Jonassiewertsen\StatamicButik\Http\Models\Order;
use Statamic\View\View as StatamicView;

class CheckoutController extends Checkout
{
    public function delivery()
    {
        $customer = session()->has('butik.customer') ?
            Session::get('butik.customer') :
            (new Customer())->empty();



        return (new StatamicView())
           ->template(config('butik.template_checkout-delivery'))
           ->layout(config('butik.layout_checkout-delivery'))
           ->with([
                'customer'         => $customer,
                'countries'        => Country::pluck('name', 'slug'),
                'selected_country' => Cart::country(),
                'items'            => $this->mappedCartItems(),
                'total_price'      => Cart::totalPrice(),
                'total_shipping'   => Cart::totalShipping(),
            ]);
    }

    public function saveCustomerData()
    {
        $validatedData = request()->validate($this->rules());

        $customer = new Customer($validatedData);
        Session::put('butik.customer', $customer);

        if ($validatedData['country'] !== Cart::country()['slug']) {
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
                'customer'       => session('butik.customer'),
                'items'          => $this->mappedCartItems(),
                'total_price'    => Cart::totalPrice(),
                'total_shipping' => Cart::totalShipping(),
            ]);
    }

    public function receipt(Request $request, $order)
    {
        if (!$request->hasValidSignature()) {
            return $this->showInvalidReceipt();
        }

        if (!$order = Order::find($order)) {
            return $this->showInvalidReceipt();
        }

        $customer = json_decode($order->customer);

        if ($order->status === 'paid') {
            Session::forget('butik.customer');
        }

        return view(config('butik.template_checkout-receipt'), compact('customer', 'order'));
    }

    /**
     * Antlers can't handle objects and collections very well.
     * To make them play nice together, we will return an
     * array with all needed informations for the
     * checkout process.
     */
    private function mappedCartItems()
    {
        return Cart::get()->map(function ($item) {
            return [
                'available'      => $item->available,
                'sellable'       => $item->sellable,
                'availableStock' => $item->availableStock,
                'slug'           => $item->slug,
                'images'         => $item->images,
                'name'           => $item->name,
                'description'    => $item->description,
                'single_price'   => $item->singlePrice(),
                'total_price'    => $item->totalPrice(),
                'quantity'       => $item->getQuantity(),
            ];
        });
    }
}
