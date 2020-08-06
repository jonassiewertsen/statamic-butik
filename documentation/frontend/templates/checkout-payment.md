---
description: This is the  second checkout step.
---

# Checkout Payment



```text
/shop/checkout/payment

/checkout/payment.antlers.html
```

We will show all the provided data again. After confirmation, the customer will be redirect to [Mollie](www.mollie.com) for his payment.

## Tags

| Options | Description |
| :--- | :--- |
| **customer** | Will empty the first time. After submitting the first form, it will contain all needed customer information. |
| **items** | All items in the bag the customer wants to purchase. |

## Functionality

### Remove non-sellable items

In case the user has some unsaleable items in his bag \(shopping cart\), because they are not available in his country, we will remove them as soon as we load this page. 

