<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Jonassiewertsen\StatamicButik\Http\Models\Product;

class ExpressCheckoutController extends Controller
{
    public function delivery(Product $product) {
       return (new \Statamic\View\View())
           ->template('statamic-butik::web.checkout.express.delivery')
           ->with($product->toArray());
    }

    public function customerData(Product $product) {
        $validatedData = request()->validate($this->rules());

        Session::put('butik.customer', $validatedData);
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
