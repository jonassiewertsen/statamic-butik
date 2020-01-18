<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers;

use Illuminate\Routing\Controller as LaravelController;

class WebController extends LaravelController
{
    protected function addingProductRoutes($product): array {
        // Todo: Maybe this could be refactored into something cleaner?
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
            'express_delivery_url' => $product->expressDeliveryUrl,
            'express_payment_url'  => $product->expressPaymentUr,
        ];
    }
}
