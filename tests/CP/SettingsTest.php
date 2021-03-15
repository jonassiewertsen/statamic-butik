<?php

namespace Tests\CP;

use Tests\TestCase;

class SettingsTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->signInAdmin();
    }

    /** @test */
    public function the_index_page_will_be_shown()
    {
        $this->get(cp_route('butik.settings.index'))->assertOk();
    }
}
