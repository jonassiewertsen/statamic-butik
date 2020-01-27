<?php

namespace Jonassiewertsen\StatamicButik\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Jonassiewertsen\StatamicButik\Http\Models\Product;

class ReduceProductStock implements ShouldQueue
{
    use SerializesModels;

    public function handle($event)
    {
        $product = $event->transaction->products[0];
        $product = Product::findOrFail($product['slug']);

        if ($product->stock_unlimited) {
            return;
        }

        $product->stock--;
        $product->save();
    }
}