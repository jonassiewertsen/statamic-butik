<?php

namespace Jonassiewertsen\StatamicButik;

use Illuminate\Support\Facades\Gate;
use Jonassiewertsen\StatamicButik\Http\Middleware\DeletingTransactionData;
use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Policies\ProductPolicy;
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
        \Jonassiewertsen\StatamicButik\Http\Tags\Route::class,
    ];

    protected $listen = [
        \Jonassiewertsen\StatamicButik\Events\PaymentSuccessful::class => [
            \Jonassiewertsen\StatamicButik\Listeners\SendPurchaseConfirmationToCustomer::class,
            \Jonassiewertsen\StatamicButik\Listeners\SendPurchaseConfirmationToSeller::class,
            \Jonassiewertsen\StatamicButik\Listeners\CreateOrder::class,
        ],
    ];

    protected $scripts = [
        __DIR__ . '/../public/js/statamic-butik.js',
    ];

    protected $policies = [
        Product::class => ProductPolicy::class,
    ];

    public function boot()
    {
         parent::boot();

         $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'statamic-butik');
         $this->loadViewsFrom(__DIR__.'/../resources/views', 'statamic-butik');
         $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

         $this->registerPolicies();
         $this->registerPermissions();
         $this->registerMiddleware();
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
    }

    private function createNavigation(): void {
        Nav::extend(function ($nav) {

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
                ->route('butik.taxes.index')
                ->children([
                   'Taxes'    => cp_route('butik.taxes.index')->can('view taxes'),
                   'Shippings' => cp_route('butik.shippings.index')->can('view shippings'),
               ]);
        });
    }

    public function registerPolicies()
    {
        foreach ($this->policies as $key => $value) {
            Gate::policy($key, $value);
        }
    }

    private function registerMiddleware() {
        $router = $this->app['router'];
        $router->pushMiddlewareToGroup('web', DeletingTransactionData::class);
    }

    private function registerPermissions() {
        $this->app->booted(function () {
            Permission::group('butik', 'Statamic Butik', function () {
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
