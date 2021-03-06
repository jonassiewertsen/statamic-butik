<?php

namespace Jonassiewertsen\Butik\Http\Controllers\CP;

use Illuminate\Http\Request;
use Jonassiewertsen\Butik\Blueprints\VariantBlueprint;
use Jonassiewertsen\Butik\Http\Controllers\CpController;
use Jonassiewertsen\Butik\Http\Models\Variant;

class VariantsController extends CpController
{
    public function store(Request $request)
    {
        $this->authorize('store', Variant::class);

        /**
         * TODO: Remove this ugly fix as soon as custom rules can be used in blueprints.
         *
         * https://github.com/statamic/cms/issues/2028
         */
        if ($request['price'] === null || $request['price'] === '') {
            $request['price'] = 0;
        }

        $blueprint = new VariantBlueprint();
        $fields = $blueprint()->fields()->addValues($request->all());
        $fields->validate();
        $values = $fields->process()->values();
        $variant = $values->toArray();

        Variant::create([
            'available'       => $variant['available'],
            'title'           => $variant['title'],
            'product_slug'    => $variant['product_slug'],
            'inherit_price'   => $variant['inherit_price'],
            'price'           => $variant['price'],
            'inherit_stock'   => $variant['inherit_stock'],
            'stock'           => $variant['stock'],
            'stock_unlimited' => $variant['stock_unlimited'],
        ]);
    }

    public function update(Request $request, Variant $variant)
    {
        $this->authorize('update', $variant);

        $blueprint = new VariantBlueprint();
        $fields = $blueprint()->fields()->addValues($request->all());
        $fields->validate();
        $values = $fields->process()->values()->toArray();

        $variant->update([
            'available'       => $values['available'],
            'title'           => $values['title'],
            'inherit_price'   => $values['inherit_price'],
            'price'           => $values['price'],
            'inherit_stock'   => $values['inherit_stock'],
            'stock'           => $values['stock'],
            'stock_unlimited' => $values['stock_unlimited'],
        ]);
    }

    public function destroy(Variant $variant)
    {
        $this->authorize('delete', $variant);

        $variant->delete();
    }

    public function from($product)
    {
        return Variant::where('product_slug', $product)
            ->get()
            ->map(function ($variant) {
                return [
                    'id'              => $variant->id,
                    'available'       => $variant->available,
                    'title'           => $variant->original_title,
                    'inherit_price'   => $variant->inherit_price,
                    'price'           => $variant->original_price,
                    'product_slug'    => $variant->product_slug,
                    'inherit_stock'   => $variant->inherit_stock,
                    'stock'           => $variant->original_stock,
                    'stock_unlimited' => $variant->original_stock_unlimited,
                ];
            });
    }
}
