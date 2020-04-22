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
        $item = $event->transaction->items[0]; // TODO: Refactor for multiple items
        $item = json_decode($item);
        $product = Product::findOrFail($item->id);

        if ($product->stock_unlimited) {
            return;
        }

        $product->stock--;
        $product->save();
    }
}
