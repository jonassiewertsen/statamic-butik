<?php

namespace Tests\Rules;

use Jonassiewertsen\StatamicButik\Http\Models\ShippingProfile;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingZone;
use Jonassiewertsen\StatamicButik\Rules\CountryUniqueInProfile;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class CountryUniqueInProfileTest extends TestCase
{
    /** @test */
    public function will_return_true_if_the_country_is_unique_in_this_profile()
    {
        $rule = new CountryUniqueInProfile($this->createZones()->slug);

        $this->assertTrue($rule->passes('attribute', ['US']));
    }

    /** @test */
    public function will_return_true_if_the_country_code_is_only_present_in_another_shipping_profile()
    {
        $rule = new CountryUniqueInProfile($this->createZones()->slug);

        $this->assertTrue($rule->passes('attribute', ['GB']));
    }

    /** @test */
    public function will_return_false_if_the_country_code_is_already_present_in_the_shipping_profile()
    {
        $rule = new CountryUniqueInProfile($this->createZones()->slug);

        $this->assertFalse($rule->passes('attribute', ['DE']));
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
