<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers\CP;

use Illuminate\Http\Request;
use Jonassiewertsen\StatamicButik\Blueprints\CategoryBlueprint;
use Jonassiewertsen\StatamicButik\Http\Controllers\CpController;
use Jonassiewertsen\StatamicButik\Http\Models\Category;

class CategoriesController extends CpController
{
    public function store(Request $request)
    {
//        $this->authorize('store', Country::class); TODO: Add authorization

        $blueprint = new CategoryBlueprint();
        $fields    = $blueprint()->fields()->addValues($request->all());
        $fields->validate();
        $values = $fields->process()->values();
        Category::create($values->toArray());
    }

    public function update(Request $request, Category $category)
    {
//        $this->authorize('update', $country);

        $blueprint = new CategoryBlueprint();
        $fields    = $blueprint()->fields()->addValues($request->all());
        $fields->validate();
        $values = $fields->process()->values();
        $category->update($values->toArray());
    }

    public function destroy(Category $category)
    {
//        $this->authorize('delete', $category);

        $category->delete();
    }
}
