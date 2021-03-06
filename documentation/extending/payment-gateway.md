---
description: >-
  In case you want to implement your own Payment Gateway butik offers a
  solution.
---

# Payment Gateway

{% hint style="info" %}
This part of the docs requires more testing and polishing.
{% endhint %}

```text
// config/butik.php

'payment_gateway' => SomeNamespace\YourPaymentGateway::class,
```

In your own implementation, you need to extend or `PaymentGateway` and implement our `PaymentGatewayInterface`

```text
<?php

namespace SomeNamespace;

use Jonassiewertsen\Butik\Checkout\Customer;
use Jonassiewertsen\Butik\Checkout\Transaction;
use Jonassiewertsen\Butik\Events\PaymentSubmitted;
use Jonassiewertsen\Butik\Events\PaymentSuccessful;

class YourPaymentGateway extends PaymentGateway implements PaymentGatewayInterface
{
    public function handle(Customer $customer, Collection $items, string $totalPrice)
    {
        // Do your stuff
        
        $transaction = (new Transaction())
            ->id()             // Order id used by Statamic
            ->transactionId()  // From your payment provider
            ->method()         // can be left empty
            ->totalAmount($totalPrice)
            ->createdAt()     // Carbon instance
            ->items($items)
            ->customer($customer);

        event(new PaymentSubmitted($transaction));
    }
    
    public function webhook(Request $request)
    { 
        // event(new PaymentSuccessful($payment));
    }
}
```

