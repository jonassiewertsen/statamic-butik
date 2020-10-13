<?php

use Statamic\Facades\Site;
use Statamic\Support\Str;

/**
 * GLOBAL HELPER for Statamic Butik
 */

/**
 * Return the currency symbol
 */
if (! function_exists('currency')) {
    function currency()
    {
        return config('butik.currency_symbol');
    }
}

/**
 * Return the actual used locale
 */
if (! function_exists('locale')) {
    function locale($ensureRight = false)
    {
        return Str::ensureRight(Site::current()->url(), $ensureRight ? '/' : '');
    }
}
