<?php

namespace Jonassiewertsen\StatamicButik\Tests\Utilities;

use Jonassiewertsen\StatamicButik\StatamicButikServiceProvider;

trait SetupTestTrait {
    /**
     * Load package service provider
     * @param  \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            StatamicButikServiceProvider::class,
        ];
    }

//    /**
//     * Load package alias
//     * @param  \Illuminate\Foundation\Application $app
//     * @return array
//     */
//    protected function getPackageAliases($app)
//    {
//        return [
//            'Cinema51' => \Jonassiewertsen\Cinema51\Cinema51Facade::class,
//        ];
//    }
}
