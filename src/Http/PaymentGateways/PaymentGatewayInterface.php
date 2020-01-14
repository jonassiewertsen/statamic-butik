<?php

namespace Jonassiewertsen\StatamicButik\Http\PaymentGateways;

use Illuminate\Http\Request;

interface PaymentGatewayInterface {
    public function handle(Request $request);
}
