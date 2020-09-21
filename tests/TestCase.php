<?php

namespace Jonassiewertsen\StatamicButik\Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Config;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Statamic\Extend\Manifest;
use Statamic\Facades\Blueprint;
use Statamic\Facades\Role;
use Statamic\Stache\Stores\UsersStore;
use Statamic\Statamic;

class TestCase extends OrchestraTestCase
{
    use DatabaseMigrations;
    use WithFaker;

    protected $shouldFakeVersion = true;

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        if ($this->shouldFakeVersion) {
            \Facades\Statamic\Version::shouldReceive('get')->andReturn('3.0.0-testing');
            $this->addToAssertionCount(-1); // Dont want to assert this
        }

        $this->withFactories(__DIR__ . '/../database/factories');

        $this->setCountry();
    }

    /**
     * Setup up the Faker instance.
     * @return void
     */
    protected function setUpFaker()
    {
        $this->faker = $this->makeFaker('de_DE');
    }

    /**
     * Sign in a Statamic user
     * @param array $permissions
     * @return mixed
     */
    protected function signInUser($permissions = [])
    {
        $role = Role::make()->handle('test')->title('Test')->addPermission($permissions)->save();

        $user = \Statamic\Facades\User::make();
        $user->id(1)->email('test@mail.de')->assignRole($role);
        $this->be($user);
        return $user;
    }

    /**
     * Sign in a Statamic user as admin
     * @return mixed
     */
    protected function signInAdmin()
    {
        $user = \Statamic\Facades\User::make();
        $user->id(1)->email('test@mail.de')->makeSuper();
        $this->be($user);
        return $user;
    }

    /**
     * This will set the country and write it to our config file
     */
    protected function setCountry(): void
    {
        Config::set('butik.country', 'DE');
    }

    /**
     * Load package service provider
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            \Statamic\Providers\StatamicServiceProvider::class,
            \Jonassiewertsen\StatamicButik\StatamicButikServiceProvider::class,
            \Livewire\LivewireServiceProvider::class,
        ];
    }

    /**
     * Load package alias
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            'Statamic' => Statamic::class,
        ];
    }

    /**
     * Load Environment
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        $app->make(Manifest::class)->manifest = [
            'jonassiewertsen/statamic-butik' => [
                'id'        => 'jonassiewertsen/statamic-butik',
                'namespace' => 'Jonassiewertsen\\StatamicButik\\',
            ],
        ];
    }

    /**
     * Resolve the Application Configuration and set the Statamic configuration
     * @param \Illuminate\Foundation\Application $app
     */
    protected function resolveApplicationConfiguration($app)
    {
        parent::resolveApplicationConfiguration($app);

        $configs = [
            'assets', 'cp', 'forms', 'routes', 'static_caching',
            'sites', 'stache', 'system', 'users',
        ];

        foreach ($configs as $config) {
            $app['config']->set("statamic.$config", require(__DIR__ . "/../vendor/statamic/cms/config/{$config}.php"));
        }

        // Setting the user repository to the default flat file system
        $app['config']->set('statamic.users.repository', 'file');
        $app['config']->set('statamic.stache.stores.users', [
            'class' => UsersStore::class,
            'directory' => __DIR__.'/__fixtures/users',
        ]);

        // Assume the pro edition within tests
        $app['config']->set('statamic.editions.pro', true);

        Statamic::pushCpRoutes(function () {
            return require_once realpath(__DIR__ . '/../routes/cp.php');
        });

        Statamic::pushWebRoutes(function () {
            return require_once realpath(__DIR__ . '/../routes/web.php');
        });

        // Define butik config settings for all of our tests
        $app['config']->set("butik", require(__DIR__ . "/../config/config.php"));

        // Set all layouts to null to prevent an error thrown from a layout which could not be found.
        $layouts = [
            'layout_product-index',
            'layout_product-category',
            'layout_product-show',
            'layout_cart',
            'layout_checkout-delivery',
            'layout_checkout-payment',
            'layout_checkout-receipt',
            'layout_checkout-receipt-invalid',
        ];

        foreach($layouts as $layout) {
            $app['config']->set('butik.' . $layout, null);
        }

        Blueprint::setDirectory(__DIR__.'/../resources/blueprints');
    }
}
