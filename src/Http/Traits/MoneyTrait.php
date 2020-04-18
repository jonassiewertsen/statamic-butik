<?php

namespace Jonassiewertsen\StatamicButik\Http\Traits;

/**
 * TODO: Should be refactored into it's own class
 */
trait MoneyTrait
{
    public function makeAmountHuman($value)
    {
        $value = floatval($value) / 100;

        $delimiter = config('butik.currency_delimiter');
        return number_format($value, 2, $delimiter, '');
    }

    public function makeAmountSaveable($value)
    {
        return number_format(floatval($value) * 100, 0, '', '');
    }

    public static function makeAmountHumanStatic($value)
    {
        $value = floatval($value) / 100;

        $delimiter = config('butik.currency_delimiter');
        return number_format($value, 2, $delimiter, '');
    }

    public static function makeAmountSaveableStatic($value)
    {
        return number_format(floatval($value) * 100, 0, '', '');
    }
}
