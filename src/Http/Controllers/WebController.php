<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers;

use Illuminate\Routing\Controller as LaravelController;

class WebController extends LaravelController
{
    protected function customerDataComplete() {

        if (! session()->has('butik.cart')) {
            return false;
        }

        $cart = session()->get('butik.cart');

        $keys = collect(['name', 'mail', 'country', 'address1', 'city', 'zip']);

        foreach ($keys as $key) {
            // Return false in case one of the keys does not exist inside the session data
            if (empty($cart->customer->$key)) {
                return false;
            }
        }

        return true;
    }

    protected function addingProductRoutes($product): array {
        // Todo: This is working, but sucks. Do something about it.
        return [
            'title'                => $product->title,
            'description'          => $product->description,
            'images'               => $product->images,
            'base_price'           => $product->base_price,
            'total_price'          => $product->total_price,
            'tax_amount'           => $product->tax_amount,
            'tax_percentage'       => $product->tax_percentage,
            'shipping_amount'      => $product->shipping_amount,
            'show_url'             => $product->showUrl,
            'stock'                => $product->stock,
            'stock_unlimited'      => $product->stock_unlimited,
            'express_delivery_url' => $product->expressDeliveryUrl,
            'express_payment_url'  => $product->expressPaymentUr,
        ];
    }
}
