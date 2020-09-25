<?php

namespace Jonassiewertsen\StatamicButik\Rules;

use Illuminate\Contracts\Validation\Rule;
use Facades\Jonassiewertsen\StatamicButik\Http\Models\Product;

class ProductSlugExists implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return Product::exists($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The product slug does not exist.';
    }
}
