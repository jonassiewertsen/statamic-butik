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
    function locale()
    {
        return (string) Str::of(Site::current()->locale())->explode('_')->first();
    }
}

/**
 * Return the multisite url
 */
if (! function_exists('locale_url')) {
    function locale_url()
    {
        return (string) Site::current()->url();
    }
}
