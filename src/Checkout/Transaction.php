<?php

namespace Jonassiewertsen\StatamicButik\Checkout;

use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Collection;

class Transaction {
    public string     $id;
    public string     $orderNumber;
    public string     $status;
    public string     $method;
    public string     $currencyIsoCode;
    public string     $currencySymbol;
    public string     $totalAmount;
    public Collection $items;
    public Customer   $customer;
    public Carbon     $createdAt;
    public Carbon     $paidAt;

    public function __construct(){
        $this->currencyIsoCode  = config('butik.currency_isoCode', '');
        $this->currencySymbol   = config('butik.currency_symbol', '');
    }

    public function id(string $value): self {
        $this->id = $value;
        return $this;
    }

    public function orderNumber(string $value): self {
        $this->orderNumber = $value;
        return $this;
    }

    public function status(string $value): self {
        $this->status = $value;
        return $this;
    }

    public function method(string $value): self {
        $this->method = $value;
        return $this;
    }

    public function currencyIsoCode(string $value): self {
        $this->currencyIsoCode = $value;
        return $this;
    }

    public function currencySymbol(string $value): self {
        $this->currencySymbol = $value;
        return $this;
    }

    public function totalAmount(string $value): self {
        $this->totalAmount = $value;
        return $this;
    }

    public function items(Collection $value, $fromDatabase = false): self
    {
        if ($fromDatabase) {
            $this->items = $value;
            return $this;
        }

        $this->items = $value->map(function($item) {
            return [
                'id'             => $item->slug,
                'name'           => $item->name,
                'description'    => $item->description,
                'quantity'       => $item->getQuantity(),
                'singlePrice'    => $item->singlePrice(),
                'totalPrice'     => $item->totalPrice(),
                'taxRate'        => $item->taxRate,
            ];
        });

        return $this;
    }

    public function customer(Customer $value): self {
        $this->customer = $value;
        return $this;
    }

    public function createdAt(Carbon $value): self {
        $this->createdAt = $value;
        return $this;
    }

    public function paidAt(DateTime $value): self {
        $this->paidAt = $value;
        return $this;
    }
}
