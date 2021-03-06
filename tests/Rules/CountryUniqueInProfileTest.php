<?php

namespace Tests\Rules;

use Jonassiewertsen\Butik\Http\Models\ShippingProfile;
use Jonassiewertsen\Butik\Http\Models\ShippingZone;
use Jonassiewertsen\Butik\Rules\CountryUniqueInProfile;
use Jonassiewertsen\Butik\Tests\TestCase;

class CountryUniqueInProfileTest extends TestCase
{
    protected CountryUniqueInProfile $rule;

    public function setUp(): void
    {
        parent::setUp();
        $this->rule = new CountryUniqueInProfile(
            $this->createZones()->slug,
            ShippingZone::first()
        );
    }

    /** @test */
    public function will_return_true_if_the_country_is_unique_in_this_profile()
    {
        $this->assertTrue($this->rule->passes('attribute', ['US']));
    }

    /** @test */
    public function will_return_true_if_the_country_code_is_only_present_in_another_shipping_profile()
    {
        $this->assertTrue($this->rule->passes('attribute', ['GB']));
    }

    /** @test */
    public function will_return_true_if_the_country_code_is_already_present_but_from_its_own_shipping_zone()
    {
        $this->assertTrue($this->rule->passes('attribute', ['DE']));
    }

    private function createZones(): ShippingProfile
    {
        $shippingProfile = create(ShippingProfile::class)->first();

        // Belonging to shipping profile 1
        create(ShippingZone::class, [
            'shipping_profile_slug' => $shippingProfile->slug,
            'countries' => ['DE'],
        ]);

        // Belonging to shipping profile 1
        create(ShippingZone::class, [
            'shipping_profile_slug' => $shippingProfile->slug,
            'countries' => ['DK', 'EN'],
        ]);

        // Belonging to another shipping profile
        create(ShippingZone::class, [
            'countries' => ['GB'],
        ]);

        return $shippingProfile;
    }
}
