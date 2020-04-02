<?php

namespace Jonassiewertsen\StatamicButik\Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Statamic\Extend\Manifest;
use Statamic\Facades\AssetContainer;
use Statamic\Facades\Blueprint;
use Statamic\Facades\Role;
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
    }

    protected function signInUser($permissions = [])
    {
        $role = Role::make()->handle('test')->title('Test')->addPermission($permissions)->save();

        $user = \Statamic\Facades\User::make();
        $user->id(1)->email('test@mail.de')->assignRole($role);
        $this->be($user);
        return $user;
    }

    protected function signInAdmin()
    {
        $user = \Statamic\Facades\User::make();
        $user->id(1)->email('test@mail.de')->makeSuper();
        $this->be($user);
        return $user;
    }

    protected function assertStatamicTemplateIs($template, $route) {
        return $this->assertEquals(
            $this->get($route)->getOriginalContent()->template(),
            $template
        );
    }

    protected function assertStatamicLayoutIs($layout, $route) {
        return $this->assertEquals(
            $this->get($route)->getOriginalContent()->layout(),
            $layout
        );
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
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        $app->make(Manifest::class)->manifest = [
            'jonassiewertsen/statamic-butik' => [
                'id' => 'jonassiewertsen/statamic-butik',
                'namespace' => 'Jonassiewertsen\\StatamicButik\\',
            ],
        ];
    }

    protected function resolveApplicationConfiguration($app)
    {
        parent::resolveApplicationConfiguration($app);

        $configs = [
            'assets', 'cp', 'forms', 'routes', 'static_caching',
            'sites', 'stache', 'system', 'users'
        ];

        foreach ($configs as $config) {
            $app['config']->set("statamic.$config", require(__DIR__."/../vendor/statamic/cms/config/{$config}.php"));
        }

        // Setting the user repository to the default flat file system
        $app['config']->set('statamic.users.repository', 'file');

        Statamic::pushCpRoutes(function() {
            return require_once realpath(__DIR__.'/../routes/cp.php');
        });

        Statamic::pushWebRoutes(function() {
            return require_once realpath(__DIR__.'/../routes/web.php');
        });
    }
}
