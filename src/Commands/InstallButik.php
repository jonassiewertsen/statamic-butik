<?php

namespace Jonassiewertsen\StatamicButik\Commands;

use Illuminate\Console\Command;

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
        $this->ask('Before we start. Are you ready to take off?');
        $this->info('');
        $this->info('Do you want me to setup the SQLite Database for you?');
        $this->warn('Just press yes if it is a fresh Statamic installation. In case it\'s not, make sure that SQlite ist not already set up. Pres no, if you want to use MYSQL instead. Feel free to do that.');
        $this->info('Butik won\'t interfere with existing tables. Every table will be prefixed with \'butik_\'');
        $this->ask('Type yes to let me set it up for you');

//        touch(__DIR__.'./../../../');

    }
}