<?php
/**
 * GLOBAL HELPER for Statamic Butik
 */

use Jonassiewertsen\StatamicButik\Http\Models\Settings;


/**
 * Will return the currency symbol
 */
if (!function_exists('currency')) {
    function currency()
    {
        return config('butik.currency_symbol');
    }
}
