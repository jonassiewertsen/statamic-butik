<?php

namespace Jonassiewertsen\Butik\Rules;

use Illuminate\Contracts\Validation\Rule;
use Symfony\Component\Intl\Countries;

class CountryExists implements Rule
{
    protected string $countryCode;

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
            if (! Countries::exists($countryCode)) {
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
        return 'Invalid country code: '.$this->countryCode;
    }
}
