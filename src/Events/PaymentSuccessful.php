<?php

namespace Jonassiewertsen\StatamicButik\Events;

use Illuminate\Queue\SerializesModels;

class PaymentSuccessful
{
    use SerializesModels;

    public function __construct()
    {
        dd('here');
    }
}