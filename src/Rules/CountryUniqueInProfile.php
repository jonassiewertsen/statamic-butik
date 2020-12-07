<?php

namespace Jonassiewertsen\StatamicButik\Rules;

use Illuminate\Contracts\Validation\Rule;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingProfile;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingZone;
use Jonassiewertsen\StatamicButik\Shipping\Country;

class CountryUniqueInProfile implements Rule
{
    protected ?ShippingProfile $shippingProfile;
    protected string $country;

    public function __construct(?string $shippingProfileSlug, ?ShippingZone $shippingZone)
    {
        /**
         * If creating a new profile, the profile can not be passed. In case the
         * slug is empty, the rule will pass which makes sense, because there
         * can't be any country connected to this shipping profile already.
         */
        if (! $shippingProfileSlug || ! $shippingZone) {
            return true;
        }

        $this->shippingProfile = ShippingProfile::find($shippingProfileSlug);
        $this->shippingZone = $shippingZone;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attributes
     * @param mixed $values
     * @return bool
     */
    public function passes($attribute, $values)
    {
        foreach ($values as $countryCode) {
            if ($this->countryNotSelectable($countryCode)) {
                $this->country = Country::getName($countryCode);

                return false;
            }
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The Country '.$this->country.' has already been used inside this shipping profile.';
    }

    /**
     * Does the shipping zone contain this country code already?
     *
     * @param $countryCode
     * @return bool
     */
    private function countryNotSelectable($countryCode)
    {
        if ($this->shippingZone->countries->contains($countryCode)) {
            return false;
        }

        return in_array($countryCode, $this->shippingProfile->countries);
    }
}
