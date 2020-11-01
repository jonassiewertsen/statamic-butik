---
description: You can implement your own Shipping types to calculate your shipping costs.
---

# Shipping

### Create a new shipping type

Use our command to create a gateway boilerplate.  

```bash
php please butik:shipping
```

This will give you the following boilerplate.

```php
<?php

namespace DummyNamespace;

class DummyClass extends ShippingType
{
    /**
     * Calculate the price as you need it. This example will return the price as defined
     * in your shipping rate. This is how "shipping by price" does get calculated.
     */
    public function shippingCosts(): string
    {
        return $this->rate->price;

        /**
        * As an second example. This is how we do calculate the "price per item"
        */
        // $price = $this->makeAmountSaveable($this->rate->price);
        // return $this->makeAmountHuman($price * $this->itemCount);
    }
}
```

### More flexibility needed?

No Problem. Check out the ShippingType class to see what's happening under the hood.   
Overwrite those methods from the ShippingType if needed. 

#### One example

In case you want more control over your Shipping Type name, you can overwrite the existing method.

  

```php
class DummyClass extends ShippingType
{
    protected function name(): string
    {
        return 'My new name';
    }

    public function shippingCosts(): string
    {
        // do your stuff
    }
}
```

## Add it to the config

{% hint style="info" %}
After creating your own shipping type, remember adding it to your config file.
{% endhint %}

```php
'shipping' => [
       // other types
        'new-shipping-type' => \YourNameSpace\NewShippingType::class,
    ],
```

{% page-ref page="../configuration/configuration.md" %}

