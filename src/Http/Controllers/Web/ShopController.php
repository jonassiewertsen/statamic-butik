<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers\Web;

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
                'products' => $this->fetchProducts(),
            ]);
    }

    public function category(Category $category)
    {
        return (new StatamicView())
            ->template(config('butik.template_product-category'))
            ->layout(config('butik.layout_product-category'))
            ->with([
                'products' => $category->products()->orderBy('title')->get(),
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

        return (new StatamicView())
            ->template(config('butik.template_product-show'))
            ->layout(config('butik.layout_product-show'))
            ->with(['product' => $product]);
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
        $limit   = config ('butik.overview_limit', '6');

        switch($display) {
            case 'all':
                return Product::all();
                break;
            case 'name':
                return Product::where('available', true)
                    ->orderBy('title')
                    ->limit($limit)
                    ->get();
                break;
                break;
            case 'newest':
                return Product::where('available', true)
                    ->orderByDesc('created_at')
                    ->limit($limit)
                    ->get();
                break;
            case 'cheapest':
                return Product::where('available', true)
                    ->orderBy('price')
                    ->limit($limit)
                    ->get();
                break;
            default:
                return Product::where('available', true)->get();
        }
    }
}
