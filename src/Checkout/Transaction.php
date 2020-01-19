<?php

namespace Jonassiewertsen\StatamicButik\Checkout;

use DateTime;

class Transaction {
    public string $id;
    public string $status;
    public bool $success;
    public string $type;
    public string $currencyIsoCode;
    public string $currencySymbol;
    public string $amount; // TODO: better as integer?
    public DateTime $createdAt;
}