<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers;

use Braintree_ClientToken;
use Illuminate\Support\Facades\Session;
use Jonassiewertsen\StatamicButik\Http\Models\Product;

class ExpressCheckoutController extends Controller
{
    public function delivery(Product $product) {
       return (new \Statamic\View\View())
           ->layout(config('statamic-butik.frontend.layout.checkout.express.delivery'))
           ->template(config('statamic-butik.frontend.template.checkout.express.delivery'))
           ->with($product->toArray());
    }

    public function customerData(Product $product) {
        $validatedData = request()->validate($this->rules());
        Session::put('butik.customer', $validatedData);
    }

    public function payment(Product $product) {
        return (new \Statamic\View\View())
            ->layout(config('statamic-butik.frontend.layout.checkout.express.payment'))
            ->template(config('statamic-butik.frontend.template.checkout.express.payment'))
            ->with($product->toArray());
    }

    private function rules() {
        return [
            'country'           => 'required|max:50',
            'name'              => 'required|min:5|max:50',
            'mail'              => 'required|email',
            'address_line_1'    => 'required|max:80',
            'address_line_2'    => 'nullable|max:80',
            'city'              => 'required|max:80',
            'state_region'      => 'nullable|max:80',
            'zip'               => 'required|max:20',
            'phone'             => 'nullable|max:50',
        ];
    }
}
