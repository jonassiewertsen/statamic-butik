---
description: Will show a specific product.
---

# Product Show



```text
/shop/{product}

/shop/show.antlers.html
/livewire/product-variant-section.blade.php
```

## Livewire

We added a _Livewire_ component for you, so if your customer selects a variant, it will be displayed without reloading your page. 

This is how we implement the _Livewire_ component:

```text
{{ livewire:butik.product-variant-section :product="product" }}
```

## Tags

### Main View

| Name | Description |
| :--- | :--- |
| **product** | Will return to the chosen product. |

### Livewire View

{% hint style="warning" %}
It's not possible to use Antlers inside Livewire components.
{% endhint %}

Check out how we designed the templates. You will realize, that they are nearly similar and that you can adjust the template as simple as you can with Antlers.

## Functionality

### Variant existing?

If a product has a variant, it's not allowed to visit the parents product route. 

Don't worry about, it, we already took care of it and redirected it directly to a belonging variant. 

### Product unavailable?

If it is, you will be redirected directly to our overview page.



