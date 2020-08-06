---
description: This is the first checkout step.
---

# Checkout Delivery

```text
/shop/checkout/delivery

/checkout/delivery.antlers.html
```

We will ask the customer to give his delivery information.

## Tags

| Options | Description |
| :--- | :--- |
| **customer** | Will be empty during the first order. After submitting it for the first time, all needed customer information will be filled out automatically. |
| **countries** | All available countries to ship to. |
| **selected\_country** | The selected country or default country. |
| **items** | All items from the bag the customer wants to buy. |

## Functionality

### Form validation

We will validate the form data and show an error in case something is wrong or missing.

### Selecting a new country to ship to

After selecting a new country, the customer will be redirected to this page again. 

This is important, in case some of his chosen products will not be available in his newly selected country.   
Changed shipping prices will become visible as well. 

### Item confirmation

We will always show what the customer selected and what the total price would be.

