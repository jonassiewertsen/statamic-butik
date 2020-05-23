<?php

namespace Tests\CP;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Jonassiewertsen\StatamicButik\Http\Models\Country;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingZone;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class ShippingZoneCreateTestCreateTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void {
        parent::setUp();

        $this->signInAdmin();
    }

    /** @test */
    public function a_zone_can_be_created()
    {
        $shippingZone = raw(ShippingZone::class);
        $this->post(route('statamic.cp.butik.shipping-zones.store'), $shippingZone)->assertSessionHasNoErrors();
        $this->assertEquals(1, ShippingZone::count());
    }

    /** @test */
    public function title_is_required()
    {
        $ShippingZone = raw(ShippingZone::class, ['title' => null]);
        $this->post(route('statamic.cp.butik.shipping-zones.store'), $ShippingZone)
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function shipping_is_required()
    {
        $shippingZone = raw(ShippingZone::class, ['shipping_profile_slug' => '']);
        $this->post(route('statamic.cp.butik.shipping-zones.store'), $shippingZone)
            ->assertSessionHasErrors('shipping_profile_slug');
    }

    /** @test */
    public function the_shipping_profile_relation_must_exist()
    {
        $shippingZone = raw(ShippingZone::class, ['shipping_profile_slug' => 44]);
        $this->post(route('statamic.cp.butik.shipping-zones.store'), $shippingZone)
            ->assertSessionHasErrors('shipping_profile_slug');
    }

    /** @test */
    public function it_can_add_countries()
    {
        $shippingZone = create(ShippingZone::class)->first();
        $country = create(Country::class)->first();

        $shippingZone->addCountry($country);

        $this->assertDatabaseHas('butik_country_shipping_zone', [
           'country_slug'       => $country->slug,
           'shipping_zone_id' => $shippingZone->id,
        ]);

        $this->assertCount(1, $shippingZone->fresh()->countries);
    }

    /** @test */
    public function it_can_synchronize_multiple_countries()
    {
        $shippingZone = create(ShippingZone::class)->first();
        $country1 = create(Country::class)->first();
        $country2 = create(Country::class)->first();
        $country3 = create(Country::class)->first();

        $shippingZone->addCountry($country1);
        $shippingZone->addCountry($country2);

        $shippingZone->updateCountries([$country1->slug, $country3->slug]);

        $this->assertDatabaseHas('butik_country_shipping_zone', [
                'country_slug'       => $country1->slug,
                'shipping_zone_id' => $shippingZone->id,
        ]);

        $this->assertDatabaseMissing('butik_country_shipping_zone', [
            'country_slug'       => $country2->slug,
            'shipping_zone_id' => $shippingZone->id,
        ]);

        $this->assertDatabaseHas('butik_country_shipping_zone', [
                'country_slug'       => $country3->slug,
                'shipping_zone_id' => $shippingZone->id,
        ]);

        $this->assertCount(2, $shippingZone->fresh()->countries);
    }

    /** @test */
    public function it_can_delete_countries()
    {
        $shippingZone = create(ShippingZone::class)->first();
        $country = create(Country::class)->first();

        $shippingZone->addCountry($country);

        $shippingZone->removeCountry($country);

        $this->assertCount(0, $shippingZone->fresh()->countries);
    }
}
