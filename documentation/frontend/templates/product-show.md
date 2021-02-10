---
description: Will show a specific product.
---

# Product Show

```text
/shop/{product}

/shop/show.antlers.html
/livewire/product-variant-section.blade.php
```

## Main View

| Name | Description |
| :--- | :--- |
| **product** | Will return to the chosen product. |

## Functionality

### Variant existing?

If a product has a variant, it's not allowed to visit the parents product route. 

Don't worry about, it, we already took care of it and redirected it directly to a belonging variant. 

### Product unavailable?

If it is, you will be redirected directly to our overview page.



