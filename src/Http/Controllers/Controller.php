<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers;

use Illuminate\Routing\Controller as LaravelController;

class Controller extends LaravelController
{
    protected function addingProductRoutes($product): array {
        // Todo: This needs a refactor
        return [
            'title' => $product->title,
            'description' => $product->description,
            'images' => $product->images,
            'base_price' => $product->base_price,
            'show_url' => $product->showUrl,
            'express_delivery_url' => $product->expressDeliveryUrl,
            'express_payment_url' => $product->expressPaymentUr,
        ];
    }
}
