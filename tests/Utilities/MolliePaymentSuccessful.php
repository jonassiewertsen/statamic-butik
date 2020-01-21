<?php

namespace Jonassiewertsen\StatamicButik\Tests\Utilities;

class MolliePaymentSuccessful extends MollieResponse {
    public $description = "Nice product";
    public $method      = "PayPal";
    public $status      = "paid";
    public $createdAt   = "2020-01-21T14:58:06+00:00";
    public $paidAt      = "2020-01-21T14:58:10+00:00";
    public $canceledAt  = null;
    public $resource    = "payment";
    public $id          = "fake_id";
    public $mode;
    public $amount      = "20.00";
    public $expiresAt;
    public $failedAt;
    public $settlementAmount;
    public $amountRefunded;
    public $amountRemaining;
}