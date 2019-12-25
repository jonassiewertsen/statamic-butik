<?php

namespace Jonassiewertsen\StatamicButik;

use Statamic\Facades\Nav;
use Statamic\Providers\AddonServiceProvider;

class StatamicButikServiceProvider extends AddonServiceProvider
{
    public function boot()
    {
//         parent::boot();
        // TODO: Does throw an BindingResolutionException error

         $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'statamic-butik');
         $this->loadViewsFrom(__DIR__.'/../resources/views', 'statamic-butik');
         $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
         $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
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
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/statamic-butik'),
            ], 'assets');*/

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
            $nav->create(__('statamic-butik::menu.cp.products'))
                ->section('Butik');
//            $nav->create('Orders')
//                ->section('Butik');
        });
    }
}
