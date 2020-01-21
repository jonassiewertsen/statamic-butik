<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers\PaymentGateways;

use Illuminate\Http\Request;

interface PaymentGatewayInterface {
    public function handle();
}
