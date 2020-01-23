<?php

namespace Jonassiewertsen\StatamicButik\Tests\Utilities;



class MolliePaymentOpen extends MollieResponse {
    public function __construct(){
        $this->amount = new MollieAmount();
    }

    public $description = "Nice product";
    public $method      = "PayPal";
    public $status      = "open";
    public $createdAt   = "2020-01-21T14:58:06+00:00";
    public $paidAt      = null;
    public $canceledAt  = null;
    public $resource    = "payment";
    public $id          = "tr_fake_id";
    public $mode;
    public $amount      = "20.00";
    public $expiresAt;
    public $failedAt;
    public $settlementAmount;
    public $amountRefunded;
    public $amountRemaining;
}