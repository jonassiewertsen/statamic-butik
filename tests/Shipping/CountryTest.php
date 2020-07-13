<?php

namespace Jonassiewertsen\StatamicButik\Tests\Shipping;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Jonassiewertsen\StatamicButik\Shipping\Country;
use Jonassiewertsen\StatamicButik\Tests\TestCase;
use Jonassiewertsen\StatamicButik\Http\Models\Country as CountryModel;

class CountryTest extends TestCase
{
    protected Collection $cart;

    public function setUp(): void
    {
        parent::setUp();
    }

   /** @test */
   public function a_country_can_be_set()
   {
       $country = create(CountryModel::class)->first();
       Country::set($country->slug);

       $this->assertEquals(Country::get()['name'], $country->name);
   }
   
   /** @test */
   public function if_a_country_has_not_been_set_the_default_country_will_be_returned()
   {
       $country = create(CountryModel::class)->first();

       Config::set('butik.country', $country->slug);

       $this->assertEquals(Country::get()['name'], $country->name);
   }
}
