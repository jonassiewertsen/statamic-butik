<?php

namespace Jonassiewertsen\Butik\Tags;

class Currency extends \Statamic\Tags\Tags
{
    /**
     * {{ currency }}.
     *
     * Will return by default the currency symbol
     * Equivalent to {{ currency:symbol }}
     */
    public function index()
    {
        return $this->symbol();
    }

    /**
     * {{ currency:symbol }}.
     *
     * Will return by default the currency symbol
     * Equivalent to {{ currency }}
     */
    public function symbol()
    {
        return config('butik.currency_symbol');
    }

    /**
     * {{ currency:name }}.
     *
     * Will return the currency name
     */
    public function name()
    {
        return config('butik.currency_name');
    }

    /**
     * {{ currency:iso }}.
     *
     * Will return the iso code
     */
    public function iso()
    {
        return config('butik.currency_isoCode');
    }

    /**
     * {{ currency:delimiter }}.
     *
     * Will return the delimiter
     */
    public function delimiter()
    {
        return config('butik.currency_delimiter');
    }
}
