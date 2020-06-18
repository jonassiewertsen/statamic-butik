<?php

namespace Jonassiewertsen\StatamicButik\Tests\CP;

use Jonassiewertsen\StatamicButik\Tests\TestCase;

class SettingsTest extends TestCase
{
    public function setUp(): void {
        parent::setUp();

        $this->signInAdmin();
    }

    /** @test */
    public function the_index_page_will_be_shown()
    {
        $this->withoutExceptionHandling();

        $this->get(cp_route('butik.settings.index'))->assertOk();
    }
}
