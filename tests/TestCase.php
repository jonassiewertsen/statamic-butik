<?php

namespace Jonassiewertsen\StatamicButik\Tests;

use Facades\Jonassiewertsen\StatamicButik\Http\Models\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Config;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingRate;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingZone;
use Jonassiewertsen\StatamicButik\Http\Models\Tax;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Statamic\Extend\Manifest;
use Statamic\Facades\Blueprint;
use Statamic\Facades\Collection;
use Statamic\Facades\Entry;
use Statamic\Facades\Role;
use Statamic\Facades\Site;
use Statamic\Stache\Stores\UsersStore;
use Statamic\Statamic;
use Statamic\Support\Str;

class TestCase extends OrchestraTestCase
{
    use DatabaseMigrations;
    use WithFaker;
    use PreventSavingStacheItemsToDisk;

    protected $shouldFakeVersion = true;

    public function tearDown(): void
    {
        $this->deleteFakeStacheDirectory();

        parent::tearDown();
    }

    public function multisite($site = 'de'): void
    {
        Site::setCurrent($site);
    }

    public function makeProduct(array $data = null, ShippingZone $shippingZone = null)
    {
        $shippingZone = $shippingZone ?? create(ShippingZone::class)->first();

        create(ShippingRate::class, [
            'shipping_zone_id' => $shippingZone->id,
            'minimum'          => 0,
            'price'            => 0,
        ]);

        $entryData = [
            'title'                 => $data['title'] ?? 'Test Item Product',
            'price'                 => $data['price'] ?? '20.00',
            'stock'                 => $data['stock'] ?? '5',
            'tax_id'                => $data['tax_id'] ?? create(Tax::class)->first()->slug,
            'shipping_profile_slug' => $shippingZone->profile->slug,
            'images'                => null,
        ];

        Collection::make('products')->save();

        Entry::make()
            ->collection('products')
            ->blueprint('products')
            ->slug($slug = Str::random('6'))
            ->date(now())
            ->data($entryData)
            ->id(Str::random('30'))
            ->save();

        return Product::find($slug);
    }

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        require_once __DIR__.'/ConsoleKernel.php';

        parent::setUp();

        $this->preventSavingStacheItemsToDisk();

        if ($this->shouldFakeVersion) {
            \Facades\Statamic\Version::shouldReceive('get')->andReturn('3.0.0-testing');
            $this->addToAssertionCount(-1); // Dont want to assert this
        }

        $this->withFactories(__DIR__.'/../database/factories');

        Blueprint::setDirectory(__DIR__.'/../resources/blueprints');

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
     * Sign in a Statamic user.
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
     * Sign in a Statamic user as admin.
     * @return mixed
     */
    protected function signInAdmin()
    {
        $user = \Statamic\Facades\User::make();
        $user->id(1)->email('test@mail.de')->makeSuper();
        $this->be($user);

        return $user;
    }

    protected function setCountry(): void
    {
        Config::set('butik.country', 'DE');
        Config::set('butik.currency_delimiter', ',');
    }

    /**
     * Load package service provider.
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
     * Load package alias.
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
     * Load Environment.
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
     * Resolve the Application Configuration and set the Statamic configuration.
     * @param \Illuminate\Foundation\Application $app
     */
    protected function resolveApplicationConfiguration($app)
    {
        parent::resolveApplicationConfiguration($app);

        $configs = [
            'assets', 'cp', 'routes', 'static_caching', 'sites', 'stache', 'system',
        ];

        foreach ($configs as $config) {
            $app['config']->set("statamic.$config", require(__DIR__."/../vendor/statamic/cms/config/{$config}.php"));
        }

        // Creat two site for multi site testing
        $app['config']->set('statamic.sites', [
            'sites'   => [
                'default' => ['name' => 'English', 'locale' => 'en_US', 'url' => '/'],
                'de'      => ['name' => 'Deutsch', 'locale' => 'de_DE', 'url' => '/de/'],
            ],
        ]);

        // Setting the user repository to the default flat file system
        $app['config']->set('statamic.users.repository', 'file');
        $app['config']->set('statamic.stache.watcher', false);
        $app['config']->set('statamic.stache.stores.users', [
            'class'     => UsersStore::class,
            'directory' => __DIR__.'/__fixtures/users',
        ]);
        // Set the path for our forms
        $app['config']->set('statamic.forms.forms', __DIR__.'/../resources/forms/');

        // Set the path for our entries
        $app['config']->set('statamic.stache.stores.taxonomies.directory', __DIR__.'/__fixtures__/content/taxonomies');
        $app['config']->set('statamic.stache.stores.terms.directory', __DIR__.'/__fixtures__/content/taxonomies');
        $app['config']->set('statamic.stache.stores.collections.directory', __DIR__.'/__fixtures__/content/collections');
        $app['config']->set('statamic.stache.stores.entries.directory', __DIR__.'/__fixtures__/content/collections');
        $app['config']->set('statamic.stache.stores.navigation.directory', __DIR__.'/__fixtures__/content/navigation');
        $app['config']->set('statamic.stache.stores.globals.directory', __DIR__.'/__fixtures__/content/globals');
        $app['config']->set('statamic.stache.stores.asset-containers.directory', __DIR__.'/__fixtures__/content/assets');

        // Assume the pro edition within tests
        $app['config']->set('statamic.editions.pro', true);

        Statamic::pushCpRoutes(function () {
            return require_once realpath(__DIR__.'/../routes/cp.php');
        });

        Statamic::pushWebRoutes(function () {
            return require_once realpath(__DIR__.'/../routes/web.php');
        });

        // Define butik config settings for all of our tests
        $app['config']->set('butik', require(__DIR__.'/../config/config.php'));

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

        foreach ($layouts as $layout) {
            $app['config']->set('butik.'.$layout, null);
        }
    }
}
