<?php

namespace Jonassiewertsen\StatamicButik;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Jonassiewertsen\StatamicButik\Skeleton\SkeletonClass
 */
class StatamicButikFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'statamic-butik';
    }
}
