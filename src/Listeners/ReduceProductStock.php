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
        $items = $event->transaction->items;

        foreach ($items as $item) {

            $product = Product::findOrFail($item->id);

            if ($product->stock_unlimited) {
                return;
            }

            $product->stock -= $item->quantity;
            $product->save();
        }
    }
}
