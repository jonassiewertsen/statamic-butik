<?php

namespace Tests\Tags;

use Jonassiewertsen\StatamicButik\Tags\Currency;
use Jonassiewertsen\StatamicButik\Tests\TestCase;
use Statamic\Facades\Config;

class CurrencyTagTest extends TestCase
{
    public $currency;

    public function setUp(): void
    {
        parent::setUp();
        $this->currency = new Currency();
    }

   /** @test */
   public function it_will_return_the_currency_symbol_as_default()
   {
       Config::set('butik.currency_symbol', '€');
       $this->assertEquals('€', $this->currency->index());
   }

    /** @test */
    public function it_will_return_the_currency_symbol()
    {
        Config::set('butik.currency_symbol', '€');
        $this->assertEquals('€', $this->currency->symbol());
    }

    /** @test */
    public function it_will_return_the_currency_name()
    {
        Config::set('butik.currency_name', 'Euro');
        $this->assertEquals('Euro', $this->currency->name());
    }

    /** @test */
    public function it_will_return_the_iso_code()
    {
        Config::set('butik.currency_isoCode', 'EUR');
        $this->assertEquals('EUR', $this->currency->iso());
    }

    /** @test */
    public function it_will_return_the_delimiter()
    {
        Config::set('butik.currency_delimiter', ',');
        $this->assertEquals(',', $this->currency->delimiter());
    }
}
