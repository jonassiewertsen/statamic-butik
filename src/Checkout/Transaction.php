<?php

namespace Jonassiewertsen\StatamicButik\Checkout;

use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Collection;

class Transaction {
    public string     $id;
    public string     $status;
    public string     $method;
    public string     $currencyIsoCode;
    public string     $currencySymbol;
    public string     $totalAmount;
    public Collection $products;
    public Customer   $customer;
    public Carbon     $createdAt;
    public Carbon     $paidAt;

    public function __construct(){
        $this->currencyIsoCode  = config('statamic-butik.currency.isoCode', '');
        $this->currencySymbol   = config('statamic-butik.currency.symbol', '');
    }

    public function id(string $value): self {
        $this->id = $value;
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

    public function products(Collection $value): self {
        $this->products = $value;
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