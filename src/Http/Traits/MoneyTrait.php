<?php

namespace Jonassiewertsen\StatamicButik\Http\Traits;

use Illuminate\Support\Str;

/**
 * TODO: Should be refactored into it's own class
 */
trait MoneyTrait
{
    /**
     * The amount will be made readable. An
     * int of fx 532 will be converted to 5,32
     */
    public static function makeAmountHumanStatic($value): string
    {
        $value = floatval($value) / 100;

        $delimiter = config('butik.currency_delimiter');
        return number_format($value, 2, $delimiter, '');
    }

    /**
     * To calculate with values, amounts like
     * fx 5,32 will get converted into integers of 532
     */
    public static function makeAmountSaveableStatic($value): int
    {
        // The floatval does only work with dot notation,
        // so let's replace possible commas with dots
        $value = str_replace(',', '.', $value);

        return number_format(floatval($value) * 100, 0, '', '');
    }

    /**
     * As well callable as non static function
     */
    public function makeAmountHuman($value)
    {
        return static::makeAmountHumanStatic($value);
    }

    /**
     * As well callable as non static function
     */
    public function makeAmountSaveable($value)
    {
        return static::makeAmountSaveableStatic($value);
    }
}
