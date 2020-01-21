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

// TODO: Can be cleaned up later !
//    +resource: "payment"
//    +id: "tr_yfARabw9fw"
//    +mode: "test"
//    +amount: {#1149 ▶}
//        +settlementAmount: null
//        +amountRefunded: {#1142 ▶}
//            +amountRemaining: {#1136 ▶}
//                +description: "Test"
//                +method: "paypal"
//                +status: "paid"
//                +createdAt: "2020-01-21T14:58:06+00:00"
//                +paidAt: "2020-01-21T14:58:10+00:00"
//                +canceledAt: null
//                +expiresAt: null
//                +failedAt: null
//                +profileId: "pfl_NQbPwCksP3"
//                +sequenceType: "oneoff"
//                +redirectUrl: "https://statamic.test/shop"
//                +webhookUrl: "https://26fc002c.ngrok.io/shop/payment/webhook/mollie"
//                +mandateId: null
//                +subscriptionId: null
//                +orderId: null
//                +settlementId: null
//                +locale: "en_US"
//                +metadata: "Express Checkout: Test"
//                +details: {#1144 ▶}
//                    +_links: {#1152 ▶}
//                        +_embedded: null
//                        +isCancelable: null
//                        #client: Mollie\Api\MollieApiClient {#1094 ▶}
//                        +"countryCode": "ES"
//                        +"customerId": "cst_6nBSJQGdvN"
//}

// ## FAILED
//Mollie\Api\Resources\Payment {#1145 ▼
//    +resource: "payment"
//    +id: "tr_eGEbkS4MUU"
//    +mode: "test"
//    +amount: {#1149 ▶}
//        +settlementAmount: null
//        +amountRefunded: null
//        +amountRemaining: null
//        +description: "Test"
//        +method: "paypal"
//        +status: "failed"
//        +createdAt: "2020-01-21T15:23:17+00:00"
//        +paidAt: null
//        +canceledAt: null
//        +expiresAt: null
//        +failedAt: "2020-01-21T15:23:23+00:00"
//        +profileId: "pfl_NQbPwCksP3"
//        +sequenceType: "oneoff"
//        +redirectUrl: "https://statamic.test/shop"
//        +webhookUrl: "https://26fc002c.ngrok.io/shop/payment/webhook/mollie"
//        +mandateId: null
//        +subscriptionId: null
//        +orderId: null
//        +settlementId: null
//        +locale: "en_US"
//        +metadata: "Express Checkout: Test"
//        +details: null
//        +_links: {#1136 ▶}
//            +_embedded: null
//            +isCancelable: null
//            #client: Mollie\Api\MollieApiClient {#1094 ▶}
//            +"countryCode": "ES"
//            +"customerId": "cst_fNPyQE5NWF"
//}