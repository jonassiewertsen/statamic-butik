<?php

namespace Jonassiewertsen\StatamicButik\Commands;

use Statamic\Console\RunsInPlease;

class MakeShipping extends GeneratorCommand
{
    use RunsInPlease;

    protected $signature   = 'statamic:butik:shipping';
    protected $description = 'Creates a boilerplate for your own shipping type.';
    protected $stub        = 'ShippingType.php.stub';
    protected $type        = 'Shipping';

    public function handle()
    {
        if (parent::handle() === false) {
            return false;
        }
    }
}
