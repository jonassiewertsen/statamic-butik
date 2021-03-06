<?php

namespace Jonassiewertsen\Butik\Commands;

use Statamic\Console\RunsInPlease;

class MakeGateway extends GeneratorCommand
{
    use RunsInPlease;

    protected $signature = 'statamic:butik:gateway';
    protected $description = 'Creates a boilerplate payment gateway for butik.';
    protected $stub = 'PaymentGateway.php.stub';
    protected $type = 'Gateway';

    public function handle()
    {
        if (parent::handle() === false) {
            return false;
        }
    }
}
