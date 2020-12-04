<?php

namespace Jonassiewertsen\StatamicButik\Rules;

use Illuminate\Contracts\Validation\Rule;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingProfile;

class CountryUniqueInProfile implements Rule
{
    protected ?ShippingProfile $shippingProfile;
    protected string $countryCode;

    public function __construct(string $shippingProfileSlug)
    {
        $this->shippingProfile = ShippingProfile::find($shippingProfileSlug);
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
            if ($this->shippingZoneDoesContain($countryCode)) {
                $this->countryCode = $countryCode;

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
        return 'The Country code '.$this->countryCode.' has already been used inside this shipping profile.';
    }

    /**
     * Does the shipping zone contain this country code already?
     *
     * @param $countryCode
     * @return bool
     */
    private function shippingZoneDoesContain($countryCode)
    {
        return in_array($countryCode, $this->shippingProfile->countries);
    }
}
