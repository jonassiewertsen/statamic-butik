<?php
/**
 * GLOBAL HELPER for Statamic Butik
 */


/**
 * Will return the currency symbol
 */
if (! function_exists('currency')) {
    function currency()
    {
        return config('butik.currency_symbol');
    }
}
