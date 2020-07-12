<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers\Web;

use Jonassiewertsen\StatamicButik\Http\Controllers\WebController;
use Jonassiewertsen\StatamicButik\Http\Models\Product;

class ShopController extends WebController
{
    public function index()
    {
        return view(config('butik.template_product-index'));
    }

    public function show(Product $product, $variant = null)
    {
        /**
         * We want to control if the given variant does exist so we can safely show it.
         * If it does not exist, we will redirect to an existing variant
         * or redirect to the pare nt product.
         */
        if ($variant !== null && ! $product->variantExists($variant)) {
            return $product->hasVariants() ?
                $this->redirectToVariant($product) :
                redirect($product->show_url);
        }

        /**
         * We won't redirect to the parent product if variants do exist.
         */
        if ($variant === null && $product->hasVariants()) {
            return $this->redirectToVariant($product);
        }

        /**
         * We won't show unavailable products
         */
        if (!$product->available) {
            return $this->redirectToShop();
        }

        return view(config('butik.template_product-show'), compact('product'));
    }

    private function redirectToVariant($product)
    {
        $variant = $product->variants->first();
        return redirect($variant->show_url);
    }

    private function redirectToShop()
    {
        return redirect()->route('butik.shop');
    }
}
