<?php

namespace Jonassiewertsen\StatamicButik\Tags;

use Jonassiewertsen\StatamicButik\Http\Models\Category;
use Statamic\Facades\URL;

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
                'name'       => $category->name,
                'slug'       => $category->slug,
                'url'        => $category->url,
                'is_current' => URL::getCurrent() == $category->url,
            ];
        });

        if (function_exists($this->getBool('root')) && $this->getBool('root', true)) {
            $categories->prepend($this->rootData());
        }

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

    /**
     * We can return the root category if, which will link to the product overview page.
     */
    protected function rootData()
    {
        return [
            'name'       => $this->getParam('root_name', 'Start'),
            'slug'       => null,
            'url'        => route('butik.shop'),
            'is_current' => URL::getCurrent() == route('butik.shop', [], false),
        ];
    }
}
