<?php

namespace Jonassiewertsen\StatamicButik\Blueprints;

use Illuminate\Validation\Rule;

abstract class Blueprint
{
    /**
     * Check if the actual route is equal to the given route.
     */
    protected function isRoute($route): bool
    {
        if (! isset(request()->route()->action['as'])) {
            return false;
        }

        return request()->route()->action['as'] === $route;
    }

    /**
     * Will check if the given item is unique, but will ignore the rule on the given route.
     * This is usefull, if you need to update an existing entry.
     *
     * @param  string  $table
     * @param  string  $item
     * @param  string  $route
     */
    protected function ignoreUnqiueOn($table, $item, $route)
    {
        return $this->isRoute($route) ?
            Rule::unique($table, $item)->ignore(request()->$item, $item) :
            Rule::unique($table, $item);
    }
}
