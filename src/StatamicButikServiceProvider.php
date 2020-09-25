<?php

namespace Jonassiewertsen\StatamicButik;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Jonassiewertsen\StatamicButik\Http\Models\Order;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingProfile;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingRate;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingZone;
use Jonassiewertsen\StatamicButik\Http\Models\Tax;
use Jonassiewertsen\StatamicButik\Http\Models\Variant;
use Jonassiewertsen\StatamicButik\Policies\OrderPolicy;
use Jonassiewertsen\StatamicButik\Policies\ShippingProfilePolicy;
use Jonassiewertsen\StatamicButik\Policies\ShippingRatePolicy;
use Jonassiewertsen\StatamicButik\Policies\ShippingZonePolicy;
use Jonassiewertsen\StatamicButik\Policies\TaxPolicy;
use Jonassiewertsen\StatamicButik\Policies\VariantPolicy;
use Livewire\Livewire;
use Mollie\Laravel\MollieServiceProvider;
use Statamic\Facades\CP\Nav;
use Statamic\Facades\Permission;
use Statamic\Providers\AddonServiceProvider;
use Statamic\Statamic;

class StatamicButikServiceProvider extends AddonServiceProvider
{
    protected $publishAfterInstall = false;

    protected $commands = [
        \Jonassiewertsen\StatamicButik\Commands\SetUpButik::class,
    ];

    protected $routes = [
        'cp'  => __DIR__ . '/../routes/cp.php',
        'web' => __DIR__ . '/../routes/web.php',
    ];

    protected $widgets = [
        \Jonassiewertsen\StatamicButik\Widgets\Orders::class,
    ];

    protected $modifiers = [
        \Jonassiewertsen\StatamicButik\Modifiers\CountryName::class,
        \Jonassiewertsen\StatamicButik\Modifiers\Sellable::class,
    ];

    protected $tags = [
        \Jonassiewertsen\StatamicButik\Tags\Bag::class,
        \Jonassiewertsen\StatamicButik\Tags\Categories::class,
        \Jonassiewertsen\StatamicButik\Tags\Butik::class,
        \Jonassiewertsen\StatamicButik\Tags\Currency::class,
        \Jonassiewertsen\StatamicButik\Tags\Error::class,
        // \Jonassiewertsen\StatamicButik\Tags\Product::class,
        \Jonassiewertsen\StatamicButik\Tags\Products::class,
    ];

    protected $fieldtypes = [
        \Jonassiewertsen\StatamicButik\Fieldtypes\Categories::class,
        \Jonassiewertsen\StatamicButik\Fieldtypes\Money::class,
        \Jonassiewertsen\StatamicButik\Fieldtypes\Number::class,
        \Jonassiewertsen\StatamicButik\Fieldtypes\Shipping::class,
        \Jonassiewertsen\StatamicButik\Fieldtypes\Tax::class,
        \Jonassiewertsen\StatamicButik\Fieldtypes\Variants::class,
    ];

    protected $listen = [
        \Jonassiewertsen\StatamicButik\Events\OrderCreated::class    => [],
        \Jonassiewertsen\StatamicButik\Events\OrderPaid::class       => [
            \Jonassiewertsen\StatamicButik\Listeners\SendPurchaseConfirmationToCustomer::class,
            \Jonassiewertsen\StatamicButik\Listeners\SendPurchaseConfirmationToSeller::class,
            \Jonassiewertsen\StatamicButik\Listeners\ReduceProductStock::class,
        ],
        \Jonassiewertsen\StatamicButik\Events\OrderAuthorized::class => [],
        \Jonassiewertsen\StatamicButik\Events\OrderCompleted::class  => [],
        \Jonassiewertsen\StatamicButik\Events\OrderExpired::class    => [],
        \Jonassiewertsen\StatamicButik\Events\OrderCanceled::class   => [],
        \Statamic\Events\EntryDeleted::class => [
            \Jonassiewertsen\StatamicButik\Listeners\ProductDeleted::class,
        ],
    ];

    protected $middlewareGroups = [
        'validateCheckoutRoute' => [
            \Jonassiewertsen\StatamicButik\Http\Middleware\ValidateCheckoutRoute::class,
        ],
        'cartNotEmpty'          => [
            \Jonassiewertsen\StatamicButik\Http\Middleware\CartNotEmpty::class,
        ],
        'butikRoutes'           => [
            \Jonassiewertsen\StatamicButik\Http\Middleware\UpdateCart::class,
        ],
    ];

    protected $scripts = [
        __DIR__ . '/../public/js/statamic-butik.js',
    ];

    protected $policies = [
        Order::class           => OrderPolicy::class,
        ShippingProfile::class => ShippingProfilePolicy::class,
        ShippingZone::class    => ShippingZonePolicy::class,
        ShippingRate::class    => ShippingRatePolicy::class,
        Tax::class             => TaxPolicy::class,
        Variant::class         => VariantPolicy::class,
    ];

    public function boot(): void
    {
        parent::boot();

        $this->enableForeignKeyConstraints();

        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'butik');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'butik');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->bootPermissions();
        $this->createNavigation();
        $this->bootLivewireComponents();
        $this->publishAssets();

        if ($this->app->runningInConsole()) {
            // Config
            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('butik.php'),
            ], 'butik-config');

            // Blueprints & collections
            $this->publishes([
                __DIR__ . '/../resources/blueprints' => resource_path('blueprints'),
            ], 'butik-blueprints');
            $this->publishes([
                __DIR__ . '/../resources/collections' => base_path('content/collections'),
            ], 'butik-collections');

            // Views
            $this->publishes([
                __DIR__ . '/../resources/views/email' => resource_path('views/vendor/butik/emails'),
            ], 'butik-views');
            $this->publishes([
                __DIR__ . '/../resources/views/web' => resource_path('views/vendor/butik/web'),
            ], 'butik-views');
            $this->publishes([
                __DIR__ . '/../resources/views/widgets' => resource_path('views/vendor/butik/widgets'),
            ], 'butik-views');

            // Images
            $this->publishes([
                __DIR__ . '/../public/images' => public_path('vendor/butik/images'),
            ], 'butik-images');

            // Resources
            $this->publishes([
                __DIR__ . '/../public/css' => public_path('vendor/butik/css'),
            ], 'butik-resources');
            $this->publishes([
                __DIR__ . '/../public/js' => public_path('vendor/statamic-butik/js'),
            ], 'butik-resources');

            // Lang
            $this->publishes([
                __DIR__ . '/../resources/lang' => resource_path('lang/vendor/butik'),
            ], 'butik-lang');
        }
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'butik');

        // Register the main class to use with the facade
        $this->app->singleton('statamic-butik', function () {
            return new StatamicButik;
        });

        // Registering the service provider
        $this->app->register(MollieServiceProvider::class);
    }

    protected function bootPermissions(): void
    {
        $this->app->booted(function () {
            Permission::group('butik_settings', __('butik::cp.permissions_settings'), function () {
                Permission::register('view orders', function ($permission) {
                    $permission
                        ->label(__('butik::cp.permission_view_orders'))
                        ->description(__('butik::cp.permission_view_orders_description'))
                        ->children([
                            Permission::make('show orders')
                                ->label(__('butik::cp.permission_show_orders'))
                                ->description(__('butik::cp.permission_show_orders_description')),
                            Permission::make('update orders')
                                ->label(__('butik::cp.permission_update_orders'))
                                ->description(__('butik::cp.permission_update_orders_description')),
                        ]);
                });
                Permission::register('view shippings', function ($permission) {
                    $permission
                        ->label(__('butik::cp.permission_view_shippings'))
                        ->description(__('butik::cp.permission_view_shippings_description'))
                        ->children([
                            Permission::make('edit shippings')
                                ->label(__('butik::cp.permission_edit_shippings'))
                                ->description(__('butik::cp.permission_edit_shippings_description'))
                                ->children([
                                    Permission::make('create shippings')
                                        ->label(__('butik::cp.permission_create_shippings'))
                                        ->description(__('butik::cp.permission_create_shippings_description')),
                                    Permission::make('delete shippings')
                                        ->label(__('butik::cp.permission_delete_shippings'))
                                        ->description(__('butik::cp.permission_delete_shippings_description')),
                                ]),
                        ]);
                });
                Permission::register('view taxes', function ($permission) {
                    $permission
                        ->label(__('butik::cp.permission_view_taxes'))
                        ->description(__('butik::cp.permission_view_taxes_description'))
                        ->children([
                            Permission::make('edit taxes')
                                ->label(__('butik::cp.permission_edit_taxes'))
                                ->description(__('butik::cp.permission_edit_taxes_description'))
                                ->children([
                                    Permission::make('create taxes')
                                        ->label(__('butik::cp.permission_create_taxes'))
                                        ->description(__('butik::cp.permission_create_taxes_description')),
                                    Permission::make('delete taxes')
                                        ->label(__('butik::cp.permission_delete_taxes'))
                                        ->description(__('butik::cp.permission_delete_taxes_description')),
                                ]),
                        ]);
                });
            });
        });
    }


    protected function bootLivewireComponents(): void
    {
        Livewire::component('butik.cart-list', \Jonassiewertsen\StatamicButik\Http\Livewire\CartList::class);
        Livewire::component('butik.cart-icon', \Jonassiewertsen\StatamicButik\Http\Livewire\CartIcon::class);
        Livewire::component('butik.product-variant-section', \Jonassiewertsen\StatamicButik\Http\Livewire\ProductVariantSection::class);
    }

    private function createNavigation(): void
    {
        Nav::extend(function ($nav) {

            // Orders
            $nav->create(ucfirst(__('butik::cp.order_plural')))
                ->section('Butik')
                ->can(auth()->user()->can('view orders'))
                ->route('butik.orders.index')
                ->icon('drawer-file');

            // Products
            $nav->create(ucfirst(__('butik::cp.product_plural')))
                ->section('Butik')
                ->can(auth()->user()->can('view products'))
                ->route('collections.show', 'products')
                ->icon('tags');

            // Settings
            $nav->create(ucfirst(__('butik::cp.setting_plural')))
                ->section('Butik')
                ->route('butik.settings.index')
                ->icon('settings-slider')
                ->children([
                    $nav->item(ucfirst(__('butik::cp.shipping_singular')))->route('butik.shipping.index')->can('view shippings'),
                    $nav->item(ucfirst(__('butik::cp.tax_plural')))->route('butik.taxes.index')->can('view taxes'),
                ]);
        });
    }

    private function enableForeignKeyConstraints(): void
    {
        /**
         * Enable foreign key constraints if a database is connected.
         */
        try {
            Schema::enableForeignKeyConstraints();
        } catch (\Throwable $e) {
            // Do nothing
        }
    }

    private function publishAssets(): void
    {
        Statamic::afterInstalled(function () {
            Artisan::call('vendor:publish --tag=butik-config');
            Artisan::call('vendor:publish --tag=butik-images');
            Artisan::call('vendor:publish --tag=butik-blueprints');
            Artisan::call('vendor:publish --tag=butik-collections');
            Artisan::call('vendor:publish --tag=butik-resources --force');
        });
    }
}
