<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Jonassiewertsen\StatamicButik\Exceptions\TransactionSessionDataIncomplete;
use Jonassiewertsen\StatamicButik\Http\Models\Product;

class ExpressCheckoutController extends Controller
{
    public function delivery(Product $product) {

        // Adding checkout routes to the product
        $product = $this->addingProductRoutes($product);

        // In case a customer goes back to edit, we will load his previews information
        if (session()->has('butik.customer')) {
            $formData = session('butik.customer');
            $viewData = array_merge($formData, $product);
        }

       return (new \Statamic\View\View())
           ->layout(config('statamic-butik.frontend.layout.checkout.express.delivery'))
           ->template(config('statamic-butik.frontend.template.checkout.express.delivery'))
           ->with($viewData ?? $product);
    }

    public function saveCustomerData(Product $product) {
        $validatedData = request()->validate($this->rules());

        Session::put('butik.customer', $validatedData);

        return redirect()->route('butik.checkout.express.payment', $product);
    }

    public function payment(Product $product) {
        if (! $this->customerDataComplete()) {
            return redirect($product->expressDeliveryUrl());
        }

        // Adding checkout routes to the product
        $product = $this->addingProductRoutes($product);

        // In case a customer goes back to edit, we will load his previews information
        if (session()->has('butik.customer')) {
            $formData = session('butik.customer');
            $viewData = array_merge($formData, $product);
        }

        return (new \Statamic\View\View())
            ->layout(config('statamic-butik.frontend.layout.checkout.express.payment'))
            ->template(config('statamic-butik.frontend.template.checkout.express.payment'))
            ->with($viewData ?? $product);
    }

    public function receipt(Product $product) {
        if (! $this->transactionSuccessful()) {
            return redirect($product->expressDeliveryUrl());
        }

        if (! $this->transactionDataComplete()) {
            throw new TransactionSessionDataIncomplete();
        }
        
        $session = session()->get('butik.transaction')->toArray();
        $viewData = array_merge($product->toArray(), $session['customer']);

        // TODO: Product still needed here? What about the view data?
        return (new \Statamic\View\View())
            ->layout(config('statamic-butik.frontend.layout.checkout.express.receipt'))
            ->template(config('statamic-butik.frontend.template.checkout.express.receipt'))
            ->with($viewData);
    }

    private function customerDataComplete() {
        if (! session()->has('butik.customer')) {
            return false;
        }

        $session = session()->get('butik.customer');

        $keys = collect(['name', 'mail', 'country', 'address_1', 'city', 'zip']);

        foreach ($keys as $key) {
            // Return false in case one of the keys does not exist inside the session data
            if (empty($session[$key])) {
                return false;
            }
        }

        return true;
    }

    private function transactionSuccessful() {
        return session()->has('butik.transaction.success')
        && session()->get('butik.transaction.success') === true;
    }

    private function transactionDataComplete() {
        $keys = ['success', 'id', 'type', 'currencyIsoCode', 'amount', 'created_at', 'customer'];

        foreach ($keys as $key) {
            if (session()->has("butik.transaction.{$key}")) {
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
            'address_1'         => 'required|max:80',
            'address_2'         => 'nullable|max:80',
            'city'              => 'required|max:80',
            'state_region'      => 'nullable|max:80',
            'zip'               => 'required|max:20',
            'phone'             => 'nullable|max:50',
        ];
    }
}
