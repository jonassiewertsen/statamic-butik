<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Jonassiewertsen\StatamicButik\Checkout\Customer;
use Jonassiewertsen\StatamicButik\Checkout\Cart;
use Jonassiewertsen\StatamicButik\Exceptions\TransactionSessionDataIncomplete;
use Jonassiewertsen\StatamicButik\Http\Controllers\WebController;
use Jonassiewertsen\StatamicButik\Http\Models\Product;

class ExpressCheckoutController extends WebController
{
    public function delivery(Product $product) {

        if (session()->has('butik.cart')) {
            $formData = session('butik.cart');
            $viewData = array_merge((array) $formData->customer, $product->toArray());
        }

       return (new \Statamic\View\View())
           ->layout(config('statamic-butik.frontend.layout.checkout.express.delivery'))
           ->template(config('statamic-butik.frontend.template.checkout.express.delivery'))
           ->with($viewData ?? $product->toArray());
    }

    public function saveCustomerData(Product $product) {
        $validatedData = request()->validate($this->rules());

        $cart = (new Cart)
            ->customer((new Customer)->create($validatedData))
            ->addProduct($product);

        Session::put('butik.cart', $cart);

        return redirect()->route('butik.checkout.express.payment', $product);
    }

    public function payment() {
        $cart = session()->get('butik.cart');

        if ($cart === null || $cart->products === null || $cart->products->count() > 1) {
            return redirect()->route('butik.shop');
        }

        if ($cart->products->first()->soldOut || ! $cart->products->first()->available) {
            return redirect($cart->products->first()->showUrl);
        }

        if (! $this->customerDataComplete()) {
            return redirect($cart->products->first()->ExpressDeliveryUrl);
        }

        $viewData = array_merge(
            $cart->products->first()->toArray(),
            (array) $cart->customer
        );

        return (new \Statamic\View\View())
            ->layout(config('statamic-butik.frontend.layout.checkout.express.payment'))
            ->template(config('statamic-butik.frontend.template.checkout.express.payment'))
            ->with($viewData);
    }

    public function receipt(Request $request, $id) {
        if (!$request->hasValidSignature()) {
            return (new \Statamic\View\View())
                ->layout(config('statamic-butik.frontend.layout.checkout.express.receipt'))
                ->template(config('statamic-butik.frontend.template.checkout.invalidReceipt'));
        }
        dd($id);
        if (! $this->transactionSuccessful()) {
            return redirect($product->expressDeliveryUrl);
        }

        if (! $this->transactionDataComplete()) {
            throw new TransactionSessionDataIncomplete();
        }

        $session = session()->get('butik.transaction')->toArray();
        $viewData = array_merge($product->toArray(), $session['customer']);

        // TODO: In theory another product slug could be called. The transaction itself would be correct, but
        // displaying funny things. We don't want that. It's not urgent, but should be fixed.
        return (new \Statamic\View\View())
            ->layout(config('statamic-butik.frontend.layout.checkout.express.receipt'))
            ->template(config('statamic-butik.frontend.template.checkout.express.receipt'))
            ->with($viewData);
    }

    private function transactionSuccessful() {
        return session()->has('butik.transaction.success')
        && session()->get('butik.transaction.success') === true;
    }

    private function transactionDataComplete() {
        $keys = ['success', 'id', 'type', 'currencyIsoCode', 'amount', 'created_at', 'customer'];
        foreach ($keys as $key) {
            if (! session()->has("butik.transaction.{$key}")) {
                return false;
            }
        }

        return true;
    }

    private function rules() {
        return [
            'country'           => 'required|max:50',
            'name'              => 'required|min:5|max:50',
            'mail'              => 'required|email',
            'address1'         => 'required|max:80',
            'address2'         => 'nullable|max:80',
            'city'              => 'required|max:80',
            'state_region'      => 'nullable|max:80',
            'zip'               => 'required|max:20',
            'phone'             => 'nullable|max:50',
        ];
    }
}
