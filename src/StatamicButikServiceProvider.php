<?php

namespace Jonassiewertsen\StatamicButik;

use Jonassiewertsen\StatamicButik\Http\Middleware\DeletingTransactionData;
use Statamic\Facades\Nav;
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
            \Jonassiewertsen\StatamicButik\Listeners\CreateOrder::class,
        ],
    ];

    protected $scripts = [
        __DIR__ . '/../public/js/statamic-butik.js',
    ];

    public function boot()
    {
         parent::boot();

         $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'statamic-butik');
         $this->loadViewsFrom(__DIR__.'/../resources/views', 'statamic-butik');
         $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

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
                ->route('butik.products.index')
                ->icon('tags');

            // Settings
            $nav->create('Settings')
                ->section('Butik')
                ->icon('settings-slider')
                ->children([
                   'Taxes'    => cp_route('butik.taxes.index'),
                   'Shippings' => cp_route('butik.shippings.index'),
               ]);
        });
    }

    private function registerMiddleware() {
        $router = $this->app['router'];
        $router->pushMiddlewareToGroup('web', DeletingTransactionData::class);
    }
}
