<?php

namespace Jonassiewertsen\StatamicButik\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Jonassiewertsen\StatamicButik\Http\Models\Order;
use Jonassiewertsen\StatamicButik\Http\Models\Shipping;
use Jonassiewertsen\StatamicButik\Http\Models\Tax;

class InstallButik extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'butik:install';

    protected $description = 'This will install the Butik addon';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('################################################################');
        $this->info('####################### WELCOME TO BUTIK #######################');
        $this->info('################################################################');
        $this->info('');
        $this->info('Thank you for trying me!');
        $this->confirm('Before we start. Are you ready to take off?');
        $this->info('');
        $this->info('Do you want me to setup the SQLite Database for you?');
        $this->warn('Just press yes if it is a fresh Statamic installation. In case it\'s not, make sure that SQlite ist not already set up. Pres no, if you want to use MYSQL instead. Feel free to do that.');
        $this->info('Butik won\'t interfere with existing tables. Every table will be prefixed with \'butik_\'');
        $setUpSQLIte = $this->confirm('Type yes to let me set up the sqlite database file');

        if ($setUpSQLIte) {
            touch(database_path('database.sqlite'));
        }

        $this->info('Done! Please tell your .env to use the sqlite datbase, if you want to do so. The only thing you need to add:');
        $this->warn('DB_CONNECTION=sqlite');
        $this->info('You don\'t need to specify an user, password ... just tell Laravel/Statamic to use SQLite');
        $this->info('Just ignore this information in case you will use another DB like MYSQL. No hard feelings.');

        $this->confirm('Please do that now and type yes afterwards');

        if (! DB::connection()->getDatabaseName()) {
            $this->error('I could not connect to your Database. Please try again or set it up manually.');
            die();
        }

        $this->info('I can connect to your database. Cool.');

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

        $this->info('Before letting you of the hook, we could set up your default taxes for your country');
        $taxes = $this->ask('What are the default taxes in your country? (from 1 - 100)');

        Tax::create([
            'title' => 'default',
            'slug' => 'default',
            'percentage' => $taxes,
        ]);

        $this->line('Default taxes with '.$taxes.'% have been setup. In case you misstype, just change them later. No Problem.');
        $freeShipping = $this->confirm('Do you want me to set up free shipping? Later you can add anything you want');

        if ($freeShipping) {
            Shipping::create([
                'title' => 'Free',
                'slug' => 'free',
                'price' => 0,
            ]);
        }

        $this->info('################################################################');
        $this->info('########################## THANK YOU ###########################');
        $this->info('################################################################');
        $this->info('');
        $this->info('Everyting is set up');
        $this->info('Stay in touch if you do miss some, need support or just am happy');
    }
}