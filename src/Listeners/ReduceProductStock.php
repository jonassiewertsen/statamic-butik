<?php

namespace Jonassiewertsen\StatamicButik\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Cache;
use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Http\Models\Variant;
use Statamic\Support\Str;

class ReduceProductStock implements ShouldQueue
{
    // TODO: Rewrite with the new Product model.
    public function handle($event)
    {
        $items = $event->order->items;

        foreach ($items as $item) {
            /**
             * The item can be either a variant or a product. We will fetch
             * the correct and belonging data.
             */
            $product = $this->defineProduct($item);

            /**
             * In case the stock ist unlimited, we will not reduce any.
             */
            if ($product->stock_unlimited) {
                return;
            }

            /**
             * We need to check which stock we want to reduce. The variant stock will
             * only be reduced, if it's a variant and the stock is not inherited.
             * In all other cases, the parent stock will be reduced.
             */
            if ($this->isVariant($item) && ! $product->inherit_stock)  {
                $this->reduceVariant($item);
            } else {
                $this->reduceParent($item);
            }

            Cache::forget("product:{$product->slug}");
        }
    }

    /**
     * Returing either a variant or a product.
     */
    private function defineProduct($item)
    {
        if ($this->isVariant($item)) {
            return $this->getVariant($item);
        }

        return $this->getProduct($item);
    }

    /**
     * Is the item a variant?
     */
    private function isVariant($item)
    {
        return Str::contains($item->slug, '::');
    }

    /**
     * We will get the product from the database.
     */
    private function getProduct($item)
    {
        $slug = Str::of($item->slug)->explode('::')[0];

        return Product::find($slug);
    }

    /**
     * We will get the variant from the database.
     */
    private function getVariant($item)
    {
        $variantSlug = Str::of($item->slug)->explode('::')[1];

        return Variant::find($variantSlug);
    }

    /**
     * Reducing the variant.
     */
    private function reduceVariant($item) {
       $variant = $this->getVariant($item);
       $variant->stock -= $item->quantity;
       $variant->save();
    }

    /**
     * Reducing the product or parent.
     */
    private function reduceParent($item)
    {
        $product = $this->getProduct($item);
        $product->stock -= $item->quantity;
        $product->save();
    }
}
