<?php

namespace Jonassiewertsen\Butik;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Jonassiewertsen\Butik\Cart\Cart;
use Jonassiewertsen\Butik\Contracts\CartRepository;
use Jonassiewertsen\Butik\Contracts\CountryRepository;
use Jonassiewertsen\Butik\Contracts\NumberRepository;
use Jonassiewertsen\Butik\Contracts\PriceRepository;
use Jonassiewertsen\Butik\Contracts\ProductRepository;
use Jonassiewertsen\Butik\Contracts\TaxRepository;
use Jonassiewertsen\Butik\Filters\OrderStatus;
use Jonassiewertsen\Butik\Http\Models\Order;
use Jonassiewertsen\Butik\Http\Models\ShippingProfile;
use Jonassiewertsen\Butik\Http\Models\ShippingRate;
use Jonassiewertsen\Butik\Http\Models\ShippingZone;
use Jonassiewertsen\Butik\Http\Models\Tax;
use Jonassiewertsen\Butik\Http\Models\Variant;
use Jonassiewertsen\Butik\Policies\OrderPolicy;
use Jonassiewertsen\Butik\Policies\ShippingProfilePolicy;
use Jonassiewertsen\Butik\Policies\ShippingRatePolicy;
use Jonassiewertsen\Butik\Policies\ShippingZonePolicy;
use Jonassiewertsen\Butik\Policies\TaxPolicy;
use Jonassiewertsen\Butik\Policies\VariantPolicy;
use Jonassiewertsen\Butik\Product\Product;
use Jonassiewertsen\Butik\Support\Country;
use Jonassiewertsen\Butik\Support\Number;
use Jonassiewertsen\Butik\Support\Price;
use Livewire\Livewire;
use Mollie\Laravel\MollieServiceProvider;
use Statamic\Facades\CP\Nav;
use Statamic\Facades\Permission;
use Statamic\Providers\AddonServiceProvider;
use Statamic\Statamic;

class ServiceProvider extends AddonServiceProvider
{
    protected $publishAfterInstall = false;

    protected $actions = [
        \Jonassiewertsen\Butik\Actions\Delete::class,
    ];

    protected $commands = [
        \Jonassiewertsen\Butik\Commands\SetUpButik::class,
        \Jonassiewertsen\Butik\Commands\MakeShipping::class,
        \Jonassiewertsen\Butik\Commands\MakeGateway::class,
    ];

    protected $routes = [
        'cp'  => __DIR__.'/../routes/cp.php',
        'web' => __DIR__.'/../routes/web.php',
    ];

    protected $widgets = [
        \Jonassiewertsen\Butik\Widgets\Orders::class,
    ];

    protected $scopes = [
        OrderStatus::class,
    ];

    protected $modifiers = [
        \Jonassiewertsen\Butik\Modifiers\CountryName::class,
        \Jonassiewertsen\Butik\Modifiers\Sellable::class,
        \Jonassiewertsen\Butik\Modifiers\WithoutTax::class,
    ];

    protected $tags = [
        \Jonassiewertsen\Butik\Tags\Cart::class,
        \Jonassiewertsen\Butik\Tags\Butik::class,
        \Jonassiewertsen\Butik\Tags\Currency::class,
    ];

    protected $fieldtypes = [
        \Jonassiewertsen\Butik\Fieldtypes\Countries::class,
        \Jonassiewertsen\Butik\Fieldtypes\Money::class,
        \Jonassiewertsen\Butik\Fieldtypes\Number::class,
        \Jonassiewertsen\Butik\Fieldtypes\Shipping::class,
        \Jonassiewertsen\Butik\Fieldtypes\Tax::class,
        \Jonassiewertsen\Butik\Fieldtypes\TaxType::class,
        \Jonassiewertsen\Butik\Fieldtypes\Variants::class,
    ];

    protected $listen = [
        \Jonassiewertsen\Butik\Events\OrderCreated::class    => [],
        \Jonassiewertsen\Butik\Events\OrderPaid::class       => [
            \Jonassiewertsen\Butik\Listeners\SendPurchaseConfirmationToCustomer::class,
            \Jonassiewertsen\Butik\Listeners\SendPurchaseConfirmationToSeller::class,
            \Jonassiewertsen\Butik\Listeners\ReduceProductStock::class,
        ],
        \Jonassiewertsen\Butik\Events\OrderAuthorized::class => [],
        \Jonassiewertsen\Butik\Events\OrderCompleted::class  => [],
        \Jonassiewertsen\Butik\Events\OrderExpired::class    => [],
        \Jonassiewertsen\Butik\Events\OrderCanceled::class   => [],
        // \Statamic\Events\EntrySaving::class => [
        //     \Jonassiewertsen\Butik\Listeners\CacheOldProductSlug::class,
        // ],
        // \Statamic\Events\EntrySaved::class => [
        //     \Jonassiewertsen\Butik\Listeners\RenameVariants::class,
        // ],
        \Statamic\Events\FormSubmitted::class => [
            \Jonassiewertsen\Butik\Listeners\CheckoutFormValidated::class,
        ],
    ];

    protected $middlewareGroups = [
        'validateCheckoutRoute' => [
            \Jonassiewertsen\Butik\Http\Middleware\ValidateCheckoutRoute::class,
        ],
        'cartNotEmpty'          => [
            \Jonassiewertsen\Butik\Http\Middleware\CartNotEmpty::class,
        ],
        'butikRoutes'           => [
            \Jonassiewertsen\Butik\Http\Middleware\UpdateCart::class,
        ],
    ];

    protected $scripts = [
        __DIR__.'/../public/js/statamic-butik.js',
    ];

    protected $policies = [
        Order::class           => OrderPolicy::class,
        ShippingProfile::class => ShippingProfilePolicy::class,
        ShippingZone::class    => ShippingZonePolicy::class,
        ShippingRate::class    => ShippingRatePolicy::class,
        Tax::class             => TaxPolicy::class,
        Variant::class         => VariantPolicy::class,
    ];

    /**
     * Register the application services.
     */
    public function register(): void
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'butik');

        // Registering the service provider
        $this->app->register(MollieServiceProvider::class);

        $this->app->bind(PriceRepository::class, function () {
            return new Price(
                config('butik.currency_delimiter', '.'),
                config('butik.currency_thousands_separator', '.'),
            );
        });

        $this->app->bind(NumberRepository::class, function () {
            return new Number();
        });

        $this->app->singleton(CartRepository::class, function () {
            return new Cart();
        });

        $this->app->singleton(ProductRepository::class, function () {
            return new Product();
        });

        $this->app->singleton(CountryRepository::class, function () {
            return new Country();
        });

        $this->app->singleton(TaxRepository::class, function () {
            return new \Jonassiewertsen\Butik\Repositories\TaxRepository(
                app(CountryRepository::class)
            );
        });
    }

    public function boot(): void
    {
        parent::boot();

        $this->enableForeignKeyConstraints();

        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'butik');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'butik');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->bootPermissions();
        $this->createNavigation();
        $this->bootLivewireComponents();
        $this->publishAssets();

        if ($this->app->runningInConsole()) {
            // Config
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('butik.php'),
            ], 'butik-config');

            // Blueprints
            $this->publishes([
                __DIR__.'/../resources/blueprints' => resource_path('blueprints'),
            ], 'butik-blueprints');

            // Collections
            $this->publishes([
                __DIR__.'/../resources/collections' => base_path('content/collections'),
            ], 'butik-collections');

            // Forms
            $this->publishes([
                __DIR__.'/../resources/forms' => resource_path('forms'),
            ], 'butik-forms');

            // Views
            $this->publishes([
                __DIR__.'/../resources/views/email' => resource_path('views/vendor/butik/email'),
            ], 'butik-views');
            $this->publishes([
                __DIR__.'/../resources/views/web' => resource_path('views/vendor/butik/web'),
            ], 'butik-views');
            $this->publishes([
                __DIR__.'/../resources/views/widgets' => resource_path('views/vendor/butik/widgets'),
            ], 'butik-views');

            // Images
            $this->publishes([
                __DIR__.'/../public/images' => public_path('vendor/butik/images'),
            ], 'butik-images');

            // Resources
            $this->publishes([
                __DIR__.'/../public/css' => public_path('vendor/butik/css'),
            ], 'butik-resources');
            $this->publishes([
                __DIR__.'/../public/js' => public_path('vendor/statamic-butik/js'),
            ], 'butik-resources');

            // Lang
            $this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/butik'),
            ], 'butik-lang');
        }
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
                            Permission::make('delete orders')
                                ->label(__('butik::cp.permission_delete_orders'))
                                ->description(__('butik::cp.permission_delete_orders_description')),
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
        Livewire::component('butik.add-to-cart', \Jonassiewertsen\Butik\Http\Livewire\AddToCart::class);
        Livewire::component('butik.cart-list', \Jonassiewertsen\Butik\Http\Livewire\CartList::class);
        Livewire::component('butik.cart-icon', \Jonassiewertsen\Butik\Http\Livewire\CartIcon::class);
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
                ->can(auth()->user()->can('view products entries'))
                ->route('collections.show', 'products')
                ->icon('tags');

            // Settings
            $nav->create(ucfirst(__('butik::cp.setting_plural')))
                ->section('Butik')
                ->can(auth()->user()->can('view shippings') || auth()->user()->can('view taxes'))
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
            Artisan::call('vendor:publish --tag=butik-forms');
            Artisan::call('vendor:publish --tag=butik-blueprints');
            Artisan::call('vendor:publish --tag=butik-collections');
            Artisan::call('vendor:publish --tag=butik-resources --force');
        });
    }
}
