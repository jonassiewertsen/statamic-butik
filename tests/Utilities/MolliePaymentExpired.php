<?php

namespace Jonassiewertsen\StatamicButik\Tests\Utilities;

class MolliePaymentExpired extends MollieResponse {
    public $description = "Nice product";
    public $method      = "PayPal";
    public $status      = "expired";
    public $createdAt   = "2020-01-21T14:58:06+00:00";
    public $paidAt      = null;
    public $canceledAt  = null;
    public $resource    = "payment";
    public $id          = "tr_fake_id";
    public $mode;
    public $amount      = "20.00";
    public $expiredAt   = "2020-01-24T14:58:06+00:00";
    public $failedAt    = "2020-01-21T14:58:10+00:00";
    public $settlementAmount;
    public $amountRefunded;
    public $amountRemaining;
}
