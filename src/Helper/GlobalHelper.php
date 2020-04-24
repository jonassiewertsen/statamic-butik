<?php

if (! function_exists('currency')) {
    function currency()
    {
        return config('butik.currency_symbol');
    }
}
