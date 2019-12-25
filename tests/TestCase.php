<?php

namespace Jonassiewertsen\StatamicButik\Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Jonassiewertsen\StatamicButik\Tests\Utilities\SetupTestTrait;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    use SetupTestTrait, DatabaseMigrations;

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->withFactories(__DIR__.'/../database/factories');
    }
}
