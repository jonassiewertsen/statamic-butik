<?php

namespace Jonassiewertsen\StatamicButik\Rules;

use Illuminate\Contracts\Validation\Rule;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingProfile;
use Symfony\Component\Intl\Countries;

class CountryUniqueInProfile implements Rule
{
    protected ?ShippingProfile $shippingProfile;

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
        return 'Error'; // TODO: Proper error message
    }

    private function shippingZoneDoesContain($countryCode)
    {
        return in_array($countryCode, $this->shippingProfile->countries);
    }
}
