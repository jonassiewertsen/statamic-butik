<?php

namespace Jonassiewertsen\StatamicButik\Tags;

use Jonassiewertsen\StatamicButik\Http\Models\Category;

class Categories extends \Statamic\Tags\Tags
{
    /**
     * {{ categories }}
     *
     * This tag can be used to create a nice menu to switch between categories
     */
    public function index()
    {
        $categories = Category::all()->map(function ($category) {
            return [
                'name' => $category->name,
                'slug' => $category->slug,
                'url'  => $category->url,
            ];
        });

        return $categories->toArray();
    }

    /**
     * {{ categories:count }}
     *
     * Will return the number of available categories
     */
    public function count()
    {
        return Category::count();
    }
}
