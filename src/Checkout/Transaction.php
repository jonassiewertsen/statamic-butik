<?php

namespace Jonassiewertsen\StatamicButik\Checkout;

use DateTime;
use Illuminate\Support\Collection;

class Transaction {
    public string     $id;
    public string     $status;
    public string     $type;
    public string     $currencyIsoCode;
    public string     $currencySymbol;
    public string     $totalAmount;
    public Collection $products;
    public Customer   $customer;
    public DateTime   $createdAt;
    public DateTime   $paidAt;

    public function id(string $value): self {
        $this->id = $value;
        return $this;
    }

    public function status(string $value): self {
        $this->status = $value;
        return $this;
    }

    public function type(string $value): self {
        $this->type = $value;
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

    public function createdAt(DateTime $value): self {
        $this->createdAt = $value;
        return $this;
    }

    public function paidAt(DateTime $value): self {
        $this->paidAt = $value;
        return $this;
    }
}