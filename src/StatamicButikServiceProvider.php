<?php

namespace Jonassiewertsen\StatamicButik;

use Illuminate\Support\Facades\Gate;
use Jonassiewertsen\StatamicButik\Http\Middleware\DeletingTransactionData;
use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Http\Models\Shipping;
use Jonassiewertsen\StatamicButik\Http\Models\Tax;
use Jonassiewertsen\StatamicButik\Policies\ProductPolicy;
use Jonassiewertsen\StatamicButik\Policies\ShippingPolicy;
use Jonassiewertsen\StatamicButik\Policies\TaxPolicy;
use Mollie\Laravel\MollieServiceProvider;
use Statamic\Facades\Nav;
use Statamic\Facades\Permission;
use Statamic\Providers\AddonServiceProvider;
use Statamic\Tags\Errors;

class StatamicButikServiceProvider extends AddonServiceProvider
{
    protected $routes = [
        'cp' => __DIR__.'/../routes/cp.php',
        'web' => __DIR__.'/../routes/web.php',
    ];

    protected $tags = [
        \Jonassiewertsen\StatamicButik\Http\Tags\Butik::class,
        \Jonassiewertsen\StatamicButik\Http\Tags\Braintree::class,
        \Jonassiewertsen\StatamicButik\Http\Tags\Error::class,
    ];

    protected $fieldtypes = [
        \Jonassiewertsen\StatamicButik\Fieldtypes\Money::class,
    ];

    protected $listen = [
        \Jonassiewertsen\StatamicButik\Events\PaymentSubmitted::class => [
            \Jonassiewertsen\StatamicButik\Listeners\CreateOpenOrder::class,
        ],
        \Jonassiewertsen\StatamicButik\Events\PaymentSuccessful::class => [
            \Jonassiewertsen\StatamicButik\Listeners\SendPurchaseConfirmationToCustomer::class,
            \Jonassiewertsen\StatamicButik\Listeners\SendPurchaseConfirmationToSeller::class,
        ],
    ];

    protected $scripts = [
        __DIR__ . '/../public/js/statamic-butik.js',
    ];

    protected $policies = [
        Product::class  => ProductPolicy::class,
        Shipping::class => ShippingPolicy::class,
        Tax::class      => TaxPolicy::class,
    ];

    public function boot()
    {
         parent::boot();

         $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'statamic-butik');
         $this->loadViewsFrom(__DIR__.'/../resources/views', 'statamic-butik');
         $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

         $this->bootPolicies();
         $this->bootPermissions();
         $this->bootMiddleware();
         $this->createNavigation();

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('statamic-butik.php'),
            ], 'config');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/statamic-butik'),
            ], 'views');*/

            // Publishing assets.
            $this->publishes([
                __DIR__.'/../public/images' => public_path('vendor/statamic-butik/images'),
            ], 'images');

            // Publishing assets.
            $this->publishes([
                __DIR__.'/../public/css' => public_path('vendor/statamic-butik/css/'),
            ], 'resources');

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/statamic-butik'),
            ], 'lang');*/

            // Registering package commands.
            // $this->commands([]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'statamic-butik');

        // Register the main class to use with the facade
        $this->app->singleton('statamic-butik', function () {
            return new StatamicButik;
        });

        // Registering the service provider
        $this->app->register(MollieServiceProvider::class);
    }

    private function createNavigation(): void {
        Nav::extend(function ($nav) {

            // Orders
            $nav->create(__('statamic-butik::menu.cp.orders'))
                ->section('Butik')
                ->can(auth()->user()->can('view orders'))
                ->route('butik.orders.index')
                ->icon('drawer-file');

            // Products
            $nav->create(__('statamic-butik::menu.cp.products'))
                ->section('Butik')
                ->can(auth()->user()->can('view products'))
                ->route('butik.products.index')
                ->icon('tags');

            // Settings
            $nav->create('Settings')
                ->section('Butik')
                ->icon('settings-slider')
                ->children([
                   $nav->item('Taxes')->route('butik.taxes.index')->can('view taxes'),
                   $nav->item('Shippings')->route('butik.shippings.index')->can('view shippings'),
               ]);
        });
    }

    protected function bootPolicies()
    {
        foreach ($this->policies as $key => $value) {
            Gate::policy($key, $value);
        }
    }

    protected function bootMiddleware() {
        $router = $this->app['router'];
        $router->pushMiddlewareToGroup('web', DeletingTransactionData::class);
    }

    protected function bootPermissions() {
        $this->app->booted(function () {
            Permission::group('butik', 'Statamic Butik', function () {
                Permission::register('view orders', function ($permission) {
                    $permission->children([
                        Permission::make('update orders'),
                    ]);
                });
                Permission::register('view products', function ($permission) {
                    $permission->children([
                        Permission::make('edit products')->children([
                            Permission::make('create products'),
                            Permission::make('delete products')
                        ])
                    ]);
                });
                Permission::register('view taxes', function ($permission) {
                    $permission->children([
                        Permission::make('edit taxes')->children([
                            Permission::make('create taxes'),
                            Permission::make('delete taxes')
                        ])
                    ]);
                });
                Permission::register('view shippings', function ($permission) {
                    $permission->children([
                        Permission::make('edit shippings')->children([
                            Permission::make('create shippings'),
                            Permission::make('delete shippings'),
                         ]),
                    ]);
                });
            });
        });
    }
}
