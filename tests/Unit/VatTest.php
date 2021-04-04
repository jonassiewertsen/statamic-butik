<?php

namespace Tests\Unit;

use Jonassiewertsen\Butik\Facades\Vat;
use Tests\TestCase;

class VatTest extends TestCase
{
    /** @test */
    public function it_can_convert_a_gross_price_to_a_net_price()
    {
        $vat = Vat::of('20,00')->withRate(19)->toNet();

        $this->assertEquals('16,81', $vat->get());
    }

    /** @test */
    public function it_can_convert_a_net_price_to_a_gross_price()
    {
        $vat = Vat::of('20,00')->withRate(19)->toGross();

        $this->assertEquals('23,80', $vat->get());
    }
}
