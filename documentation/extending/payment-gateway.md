---
description: In case you want to implement your own Payment Gateway.
---

# Payment Gateway

## Create a new gateway

Use our command to create a gateway boilerplate.

```bash
php please butik:gateway
```

This will give you the following boilerplate.

```php
<?php

namespace DummyNamespace;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Jonassiewertsen\StatamicButik\Checkout\Customer;
use Jonassiewertsen\StatamicButik\Http\Controllers\PaymentGateways\PaymentGateway;
use Jonassiewertsen\StatamicButik\Http\Controllers\PaymentGateways\PaymentGatewayInterface;
use Jonassiewertsen\StatamicButik\Http\Traits\MoneyTrait;

class DummyClass extends PaymentGateway implements PaymentGatewayInterface
{
    use MoneyTrait;

    /**
     * We want to handle the payment process.
     *
     * You'll find one example here:
     * Jonassiewertsen\StatamicButik\Http\Controllers\PaymentGateways\MolliePaymentGateway.php line 26
     */
    public function handle(Customer $customer, Collection $items, string $totalPrice, Collection $shippings)
    {
        $orderNumber = $this->createOrderNumber();

        // handle the payment

        // Shall we create the order for you?
        $this->createOrder(
            $payment->id,
            $items,
            $orderNumber,
            $customer,
            $totalPrice,
            $payment->method,
            $shippings,
        );

        // What to do after the payment has been handled?
    }

    /**
     * If you want, you can use webhooks. This is optional and can be left empty.
     *
     * You'll find one example here:
     * Jonassiewertsen\StatamicButik\Http\Controllers\PaymentGateways\MolliePaymentGateway.php line 53
     */
    public function webhook(Request $request): void
    {
        // Do nothing.
    }
}
```

## Use your own payment gateway

Swap the payment gateway class in your config file to use your own gateway.

{% page-ref page="../configuration/configuration.md" %}

## Webhooks

You can use webhooks if you want.

With our Mollie integration, our webhook does look like this. Maybe you'll find some inspiration:

```php
public function webhook(Request $request): void
{
    if (! $request->has('id')) {
        return;
    }

    $payment = Mollie::api()->orders()->get($request->id);

    $order = $this->findOrder($payment->id);

    switch ($payment->status) {
        case 'paid':
            $this->isPaid($order, Carbon::parse($payment->paidAt), $payment->method);
            break;
        case 'authorized':
            $this->isAuthorized($order, Carbon::parse($payment->authorizedAt), $payment->method);
            break;
        case 'completed':
            $this->isCompleted($order, Carbon::parse($payment->completedAt), $payment->method);
            break;
        case 'expired':
            $this->isExpired($order, Carbon::parse($payment->expiredAt));
            break;
        case 'canceled':
            $this->isCanceled($order, Carbon::parse($payment->canceledAt));
            break;
    }
}
```

Methods like `$this->isPaid()` will be provided for you, but you don't need to use them.

