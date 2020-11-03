<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers\CP;

use Illuminate\Http\Request;
use Jonassiewertsen\StatamicButik\Blueprints\CategoryBlueprint;
use Jonassiewertsen\StatamicButik\Http\Controllers\CpController;
use Jonassiewertsen\StatamicButik\Http\Models\Category;
use Jonassiewertsen\StatamicButik\Http\Models\Product;

class CategoriesController extends CpController
{
    public function store(Request $request)
    {
//        $this->authorize('edit', Product::class);

        $blueprint = new CategoryBlueprint();
        $fields    = $blueprint()->fields()->addValues($request->all());
        $fields->validate();
        $values = $fields->process()->values();
        Category::create($values->toArray());
    }

    public function update(Request $request, Category $category)
    {
//        $this->authorize('edit', Product::class);

        $blueprint = new CategoryBlueprint();
        $fields    = $blueprint()->fields()->addValues($request->all());
        $fields->validate();
        $values = $fields->process()->values();
        $category->update($values->toArray());
    }

    public function destroy(Category $category)
    {
//        $this->authorize('edit', Product::class);

        $category->delete();
    }

    public function attachProduct(Category $category, string $product)
    {
        $category->addProduct($product);
    }

    public function detachProduct(Category $category, string $product)
    {
        $category->removeProduct($product);
    }

    public function from($product)
    {
        return Category::orderBy('name', 'desc')->get()->map(function ($category) use ($product) {
            return [
                'name'        => $category->name,
                'slug'        => $category->slug,
                'is_attached' => $category->isProductAttached($product),
            ];
        });
    }
}
