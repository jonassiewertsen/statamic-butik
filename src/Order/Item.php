<?php

namespace Jonassiewertsen\StatamicButik\Order;

class Item
{
    public string $slug;
    public string $name;
    public ?string $description;
    public int    $quantity;
    public string $singlePrice;
    public string $totalPrice;
    public string $taxRate;
    public string $taxAmount;

    public function __construct(
        string $slug,
        string $name,
        ?string $description,
        int    $quantity,
        string $singlePrice,
        string $totalPrice,
        string $taxRate,
        string $taxAmount
    )
    {
        $this->slug        = $slug;
        $this->name        = $name;
        $this->description = $description;
        $this->quantity    = $quantity;
        $this->singlePrice = $singlePrice;
        $this->totalPrice  = $totalPrice;
        $this->taxRate     = $taxRate;
        $this->taxAmount   = $taxAmount;
    }
}
