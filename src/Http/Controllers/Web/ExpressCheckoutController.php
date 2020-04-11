<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Jonassiewertsen\StatamicButik\Checkout\Customer;
use Jonassiewertsen\StatamicButik\Checkout\Cart;
use Jonassiewertsen\StatamicButik\Http\Controllers\WebController;
use Jonassiewertsen\StatamicButik\Http\Models\Order;
use Jonassiewertsen\StatamicButik\Http\Models\Product;

class ExpressCheckoutController extends WebController
{
    public function delivery(Product $product)
    {
        if (session()->has('butik.cart')) {
            $formData = session('butik.cart');
            $viewData = array_merge((array) $formData->customer, $product->toArray());
        }

        return (new \Statamic\View\View())
            ->layout(config('butik.layout_express-checkout-delivery'))
            ->template(config('butik.template_express-checkout-delivery'))
            ->with($viewData ?? $product->toArray());
    }

    public function saveCustomerData(Product $product)
    {
        $customer = request()->validate($this->rules());

        $cart = (new Cart)->customer((new Customer($customer)));

        Session::put('butik.cart', $cart);

        return redirect()->route('butik.checkout.express.payment', $product);
    }

    public function payment() // TODO: Pass the product through the url. Not saved in the session anymore
    {
        $cart = session()->get('butik.cart');

        $viewData = array_merge(
            $cart->items->first()->product->toArray(),
            (array) $cart->customer
        );

        return (new \Statamic\View\View())
            ->layout(config('butik.layout_express-checkout-payment'))
            ->template(config('butik.template_express-checkout-payment'))
            ->with($viewData);
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
            Session::forget('butik.cart');
        }

        return (new \Statamic\View\View())
            ->layout(config('butik.layout_checkout-receipt'))
            ->template(config('butik.template_checkout-receipt'))
            ->with(
                [
                    'name'         => $customer->name,
                    'mail'         => $customer->mail,
                    'address1'     => $customer->address1,
                    'address2'     => $customer->address2,
                    'zip'          => $customer->zip,
                    'city'         => $customer->city,
                    'country'      => $customer->country,
                    'id'           => $order->id,
                    'status'       => $order->status,
                    'method'       => $order->method,
                    'total_amount' => $order->total_amount,
                ]);
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

    private function rules()
    {
        return [
            'country'      => 'required|max:50',
            'name'         => 'required|min:5|max:50',
            'mail'         => 'required|email',
            'address1'     => 'required|max:80',
            'address2'     => 'nullable|max:80',
            'city'         => 'required|max:80',
            'state_region' => 'nullable|max:80',
            'zip'          => 'required|max:20',
            'phone'        => 'nullable|max:50',
        ];
    }

    private function showInvalidReceipt() {
        return (new \Statamic\View\View())
            ->layout(config('butik.layout_checkout-receipt'))
            ->template(config('butik.template_checkout-receipt-invalid'));
    }
}
