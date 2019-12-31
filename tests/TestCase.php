<?php

namespace Jonassiewertsen\StatamicButik\Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Statamic\Facades\AssetContainer;
use Statamic\Facades\Blueprint;
use Statamic\Statamic;

class TestCase extends OrchestraTestCase
{
    use DatabaseMigrations;

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        require_once(__DIR__.'/ExceptionHandler.php');

        parent::setUp();

        $this->withFactories(__DIR__.'/../database/factories');

        $this->createContainer();
    }

    /**
     * Load package service provider
     * @param  \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            \Statamic\Providers\StatamicServiceProvider::class,
            \Jonassiewertsen\StatamicButik\StatamicButikServiceProvider::class,
        ];
    }

    /**
     * Load package alias
     * @param  \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            'Statamic' => Statamic::class,
//            'Cinema51' => \Jonassiewertsen\Cinema51\Cinema51Facade::class,
        ];
    }

    protected function createContainer()
    {
        $container = AssetContainer::make('testcontainer')
            ->title('Test Container')
            ->disk('local')
            ->blueprint(Blueprint::makeFromFields([
                'title' =>  'Assets',
                'disk' => 'assets',
            ]))
            ->allowUploads(true)
            ->createFolders('test');

        $container->save();
    }
}
