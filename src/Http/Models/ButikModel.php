<?php

namespace Jonassiewertsen\StatamicButik\Http\Models;

use Illuminate\Database\Eloquent\Model;

abstract class ButikModel extends Model {

    public function makeAmountHuman($value)
    {
        $value = floatval($value) / 100;

        $delimiter = config('statamic-butik.currency.delimiter');
        return number_format($value, 2, $delimiter, '');
    }

    public function makeAmountSaveable($value)
    {
        return number_format(floatval($value) * 100, 0, '', '');
    }
}