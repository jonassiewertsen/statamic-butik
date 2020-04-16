<?php

namespace Jonassiewertsen\StatamicButik\Http\Traits;

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
}
