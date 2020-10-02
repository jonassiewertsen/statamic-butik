<?php

namespace Jonassiewertsen\StatamicButik\Order;

class Tax
{
    /**
     * The snake case syntax might look funny, but will look as you would expect
     * if if looping through taxes in a antlers template.
     */
    public string $tax_amount;
    public int    $tax_rate;

    public function __construct(int $taxRate, string $taxAmount)
    {
        $this->tax_rate   = $taxRate;
        $this->tax_amount = $taxAmount;
    }
}
