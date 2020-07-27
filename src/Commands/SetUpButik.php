<?php

namespace Jonassiewertsen\StatamicButik\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingProfile;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingRate;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingZone;
use Jonassiewertsen\StatamicButik\Http\Models\Tax;
use Jonassiewertsen\StatamicButik\Http\Models\Country;

class SetUpButik extends Command
{
    protected $signature = 'butik:setup';

    protected $description = 'Let Statamic Butik help you through the setup process.';

    public function handle()
    {
        $this->info('################################################################');
        $this->info('################## WELCOME TO STATAMIC BUTIK ###################');
        $this->info('################################################################');
        $this->info('');
        $this->info('Thank you for trying butik!');
        $this->confirm('Should we get started?');

        $this->info('### Step 1 ################################# Statamic Butik ####');
        $this->info('#### .env file #################################################');
        $this->info('################################################################');
        $this->info('');

        $this->info('Have you configured your .env file as written in the docs?');
        $this->warn('www.butik.dev');
        $this->info('');
        $this->warn('DB_CONNECTION=sqlite');
        $this->warn('DB_FOREIGN_KEYS=true');
        $this->warn('MOLLIE_KEY=test_XXXXXXX');
        $this->info('');
        $this->confirm('Is your .env file set up? Please confirm with yes:');

        $this->info('### Step 2 ################################# Statamic Butik ####');
        $this->info('#### SQLite ####################################################');
        $this->info('################################################################');
        $this->info('');

        $this->info('Do you want me to setup the SQLite Database for you?');
        $this->warn('Just press yes if it is a fresh Statamic installation. In case it\'s not, make sure that SQlite have not already been set up. Pres no, if you want to use MYSQL instead. Feel free to do that.');
        $this->info('Butik won\'t interfere with existing tables. Every tableis prefixed with \'butik_\'');
        $setUpSQLIte = $this->confirm('Type yes to let me set up the sqlite database file.');

        if ($setUpSQLIte) {
            touch(database_path('database.sqlite'));
        }

        if (! DB::connection()->getDatabaseName()) {
            $this->error('Canceled: I could not connect to your Database. Please set up your database correctly and try again.');
            die();
        }

        $this->info('What a connection! We are already in touch with your database and it does feel good..');
        $this->info('');

        $this->info('### Step 3 ################################# Statamic Butik ####');
        $this->info('#### migration #################################################');
        $this->info('################################################################');
        $this->info('');

        $migration = $this->confirm('Do you want me to run the migration command to set up your database?');
        if ($migration) {
            Artisan::call('migrate');
            $this->info('Your Database has been set up. Yeahhh!');
        } else {
            $this->info('Please remember to call php artisan migrate by yourself');
            $continue = $this->confirm('Let me know if you did. If you did, we would create two default entires in your Dataase');
            if (! $continue) {
                $this->info('Have fun using Butik. See you hopefully soon');
                die();
            }
        }

        $this->info('### Step 4 ################################# Statamic Butik ####');
        $this->info('#### default country############################################');
        $this->info('################################################################');
        $this->info('');

        $countryIso = $this->ask('Whats your Country iso code? Your locale. Fx: de');

        $this->line('Make sure to define your default country in your config file:');
        $this->warn('https://butik.dev/installation/configuration#shop-information');
        $this->info('');

        $this->info('### Step 5 ################################# Statamic Butik ####');
        $this->info('#### default tax ###############################################');
        $this->info('################################################################');
        $this->info('');

        $taxes = $this->ask('What\'sthe default tax rate in your country? (from 1 - 100)');

        Tax::create([
            'title' => 'default',
            'slug' => 'default',
            'percentage' => $taxes,
        ]);

        $this->line('Default taxes with '.$taxes.'% have been setup. In case you misstyped, change them later. No Problem.');

        $this->info('### Step 6 ################################# Statamic Butik ####');
        $this->info('#### a shipping default #########################################');
        $this->info('################################################################');
        $this->info('');

        $shipping = $this->confirm('May I set up a default shipping setting? Please say yes. I really want to do so :-)');

        if ($shipping) {
            $shippingProfile = ShippingProfile::create([
                'title' => 'Standard',
                'slug' => 'standard',
            ]);

            $shippingZone = ShippingZone::create([
               'title' => $countryName ?? 'Default',
               'type' => 'price',
               'shipping_profile_slug' => $shippingProfile->slug,
               'countries' => [$countryIso]
            ]);

            ShippingRate::create([
                'shipping_zone_id' => $shippingZone->id,
                'title' => 'Free',
                'price' => '0',
                'minimum' => '0',
            ]);
        }

        $this->info('### Step 7 ################################# Statamic Butik ####');
        $this->info('#### publishing vendor files ###################################');
        $this->info('################################################################');
        $this->info('');

        $this->confirm('Let me publish the Statamic Butik vendor files for you. Please confirm.');

        Artisan::call('vendor:publish',[
            '--provider' => 'Jonassiewertsen\StatamicButik\StatamicButikServiceProvider',
            '--force' => true,
        ]);

        $this->info('Config: config/statamic-butik.php');
        $this->info('Views: resources/views/vendor/statamic-butik/');
        $this->info('Lang: resources/lang/vendor/statamic-butik/');
        $this->info('Images: public/vendor/statamic-butik/images/');
        $this->info('CSS: public/vendor/statamic-butik/css/');
        $this->info('');

        $this->info('################################################################');
        $this->info('########################## THANK YOU ###########################');
        $this->info('################################################################');
        $this->info('');
        $this->info('Everyting is set up');
        $this->info('');
        $this->info('Stay in touch if you do miss something or do need some help.');
    }
}
