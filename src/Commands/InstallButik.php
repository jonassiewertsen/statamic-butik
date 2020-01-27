<?php

namespace Jonassiewertsen\StatamicButik\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Jonassiewertsen\StatamicButik\Http\Models\Shipping;
use Jonassiewertsen\StatamicButik\Http\Models\Tax;

class InstallButik extends Command
{
    protected $signature = 'butik:install';

    protected $description = 'Let Statamic Butik help you through the setup process.';

    public function handle()
    {
        $this->info('################################################################');
        $this->info('################## WELCOME TO STATAMIC BUTIK ###################');
        $this->info('################################################################');
        $this->info('');
        $this->info('Thank you for trying me!');
        $this->confirm('Before we start. Are you ready to take off?');

        $this->info('### Step 1 ################################# Statamic Butik ####');
        $this->info('#### SQLite ####################################################');
        $this->info('################################################################');
        $this->info('');

        $this->info('Do you want me to setup the SQLite Database for you?');
        $this->warn('Just press yes if it is a fresh Statamic installation. In case it\'s not, make sure that SQlite ist not already set up. Pres no, if you want to use MYSQL instead. Feel free to do that.');
        $this->info('Butik won\'t interfere with existing tables. Every table will be prefixed with \'butik_\'');
        $setUpSQLIte = $this->confirm('Type yes to let me set up the sqlite database file');

        if ($setUpSQLIte) {
            touch(database_path('database.sqlite'));
        }

        $this->info('### Step 2 ################################# Statamic Butik ####');
        $this->info('#### .env file #################################################');
        $this->info('################################################################');
        $this->info('');

        $this->info('Please tell your .env to use the sqlite datbase, if you want to do so. The only thing you need to add:');
        $this->warn('DB_CONNECTION=sqlite');
        $this->warn('DB_FOREIGN_KEYS=true');
        $this->info('You don\'t need to specify any user, password ... just tell Laravel/Statamic to use SQLite');
        $this->info('');
        $this->confirm('Please do that now and type yes afterwards');

        if (! DB::connection()->getDatabaseName()) {
            $this->error('I could not connect to your Database. Please try again or set it up manually.');
            die();
        }

        $this->info('I can connect to your database. Cool.');
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
        $this->info('#### setup webhook #############################################');
        $this->info('################################################################');
        $this->info('');

        $this->info('Statamic Butik payments do work with webhooks. To get them working correclty, you need disable CSRF for one specific route.');
        $this->warn('Open the file: app/Http/Middleware/VerifyCsrfToken.php');
        $this->info('After adding the webhook route, it should look like following:');
        $this->info('');
        $this->info('protected $except = [');
        $this->info("    'payment/webhook/mollie'");
        $this->info('];');
        $this->info('');
        $this->confirm('Confirm to proceed with the setup process');

        $this->info('### Step 5 ################################# Statamic Butik ####');
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

        $this->info('### Step 6 ################################# Statamic Butik ####');
        $this->info('#### default tax ###############################################');
        $this->info('################################################################');
        $this->info('');

        $this->info('Let me create a little default data for you, before saying goodbye.');
        $taxes = $this->ask('What are the default taxes in your country? (from 1 - 100)');

        Tax::create([
            'title' => 'default',
            'slug' => 'default',
            'percentage' => $taxes,
        ]);

        $this->line('Default taxes with '.$taxes.'% have been setup. In case you misstype, just change them later. No Problem.');

        $this->info('### Step 7 ################################# Statamic Butik ####');
        $this->info('#### free shipping #############################################');
        $this->info('################################################################');
        $this->info('');

        $freeShipping = $this->confirm('Do you want me to set up free shipping? Later you can add anything you want');

        if ($freeShipping) {
            Shipping::create([
                'title' => 'Free',
                'slug' => 'free',
                'price' => 0,
            ]);
        }

        $this->info('### Step 8 ################################# Statamic Butik ####');
        $this->info('#### set up mails ##############################################');
        $this->info('################################################################');
        $this->info('');

        $this->info('Let me remind you to set up your mail settings in the statamic .env file');
        $this->info('Make sure to to test if they are working correctly. Login into the statamic control panel and send yourself a testmail.');
        $this->warn('More information: https://statamic.dev/email');

        $this->confirm('Go to next step?');

        $this->info('### Step 9 ################################# Statamic Butik ####');
        $this->info('#### set up redis ##############################################');
        $this->info('################################################################');
        $this->info('');

        $this->info('You don\'t have to use redis queues, but i would recommend doing so if you can!');
        $this->info('The short and incomplete version');
        $this->warn('Add to you env file: QUEUE_DRIVER=redis');
        $this->warn('Install predis via composer: composer require predis/predis');
        $this->warn('More information: https://laravel.com/docs/master/redis');

        $this->confirm('Go to the last step?');

        $this->info('################################################################');
        $this->info('########################## THANK YOU ###########################');
        $this->info('################################################################');
        $this->info('');
        $this->info('Everyting is set up');
        $this->info('');
        $this->info('Stay in touch if you do miss something or do need some help.');
    }
}