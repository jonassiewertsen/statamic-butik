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

/**
 * Will return butik settings
 */
if (!function_exists('butik')) {
    function butik($key, $default = null)
    {
        if (!Settings::where('key', $key)->exists()) {
            return $default;
        }

        return Settings::firstWhere('key', $key)->value;
    }
}
