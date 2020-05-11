<?php

namespace Tests\Unit;

use Jonassiewertsen\StatamicButik\Http\Models\Settings;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class SettingsTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    /** @test */
    public function Settings_can_be_called_as_global_helper_function()
    {
        $settings = factory(Settings::class)->create([
            'key'   => 'shop name',
            'value' => 'Statamic Butik',
        ])->first();

        $this->assertEquals($settings->value, butik('shop name'));
    }

    /** @test */
    public function a_not_existing_key_will_return_null()
    {
        $this->assertEquals(null, butik('not existing key'));
    }

    /** @test */
    public function a_default_value_can_be_defined()
    {
        $this->assertEquals('default', butik('not existing key', 'default'));
    }
}
