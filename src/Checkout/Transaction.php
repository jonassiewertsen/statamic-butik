<?php

namespace Jonassiewertsen\StatamicButik\Checkout;

use DateTime;

class Transaction {
    protected string $id;
    protected string $status;
    protected bool $success;
    protected string $type;
    protected string $currencyIsoCode;
    protected string $currencySymbol;
    protected string $amount; // TODO: better as integer?
    protected DateTime $createdAt;
}