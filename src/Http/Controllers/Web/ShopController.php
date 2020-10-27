<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers\Web;

use Illuminate\Support\Collection;
use Jonassiewertsen\StatamicButik\Http\Controllers\WebController;
use Jonassiewertsen\StatamicButik\Http\Models\Category;
use Facades\Jonassiewertsen\StatamicButik\Http\Models\Product;
use Statamic\View\View as StatamicView;

class ShopController extends WebController
{
    public function index()
    {
        return (new StatamicView())
            ->template(config('butik.template_product-index'))
            ->layout(config('butik.layout_product-index'))
            ->with([
                'products' => $this->convertToArray($this->fetchProducts()),
            ]);
    }

    public function category(Category $category)
    {
        $products = $this->convertToArray(Product::fromCategory($category));

        return (new StatamicView())
            ->template(config('butik.template_product-category'))
            ->layout(config('butik.layout_product-category'))
            ->with([
                'products' => $products,
            ]);
    }

    public function show(string $product, $variant = null)
    {
        $product = Product::find($product);

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
        if (! $product->available) {
            return $this->redirectToShop();
        }

        if ($product->hasVariants()) {
            $variants = $product->variants;
            $variant  = $variants->firstWhere('original_title', $variant)->toArray();
            $product  = array_merge((array)$product, $variant, ['variants' => $variants->toArray()]);
        } else {
            $product = (array)$product;
        }

        return (new StatamicView())
            ->template(config('butik.template_product-show'))
            ->layout(config('butik.layout_product-show'))
            ->with($product);
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

    private function fetchProducts()
    {
        $display = config('butik.overview_type', 'newest');

        switch ($display) {
            case 'all':
                return Product::all();
                break;
            case 'name':
                return Product::latestByName();
                break;
            case 'newest':
                return Product::latest();
                break;
            case 'cheapest':
                return Product::latestByPrice();
                break;
            default:
                return Product::all();
        }
    }

    private function convertToArray(Collection $products)
    {
        return $products->transform(function ($entry) {
            return (array) $entry;
        });
    }

}
