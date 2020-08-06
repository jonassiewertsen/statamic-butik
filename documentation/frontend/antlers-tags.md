---
description: Antlers is a simple and powerful templating engine provided Statamic.
---

# Antlers Tags

If you are familiar with Statamic, you will know the Antlers template engine. This is why we provide Antlers tags for you. 

In case you never worked with Antlers before, [read the Statamic introduction](https://statamic.dev/antlers). 

## Bag

A bag is the shopping cart in _butik._

### Items

```text
{{ bag }} // short syntax

{{ bag:items }}
```

Will return to all items from the actual bag \(shopping cart\).

| Value |  |
| :--- | :--- |
| **sellable** | Is this item available in the selected country?  |
| **available\_stock** | How many items are available. |
| **slug** | The unique identifier of the product / variant |
| **images** | Associated pictures of the product. |
| **name** | The name of the product. |
| **description** | A short description of the product. |
| **single\_price** | The price for a single item. |
| **total\_price** | The price for all selected items. |
| **quantity** | How often the item is in the bag.    |

### Total Items

```text
 {{ bag:total_items }}
```

Counting the total amount of items in the bag.

### Total Price

```text
{{ bag:total_price }}
```

Counting the costs of all items including shipping.

### Total Shipping

```text
{{ bag:total_shipping }}
```

Summing the total shipping costs for all items in the shopping bag.

## Butik

The _butik_ tag provides the most important routes.

### Shop

```text
{{ butik:shop }}
```

Will return to the shop overview route.

### Bag

```text
{{ butik:bag }}
```

Will return the route to the butik bag \(shopping cart\). 

## Categories

This tag is handy to create a menu for exisiting categories, wherever you need them on your page.

### Default

```text
{{ categories }}
```

#### Arguments

| Values | Description |
| :--- | :--- |
| **root** | Should the root category be included? \(default: true\) |
| **root\_name** | The name of the root entry, linking to the product overview page. |

#### Returns

| Values | Description |
| :--- | :--- |
| **name** | Category name |
| **slug** | Category slug |
| **url** | Category url |
| **is\_current** | true if current page |

### Count

```text
{{ categories:count }}
```

Will return to the total number of created categories.

### Example: Create categories menu

```markup
{{ if {categories:count} > 0 }}
    <a href="{{ butik:shop }}">Overview</a>
    {{ categories }}
        <a href="{{ url }}">{{ name }}</a>
    {{ /categories }}
{{ /if }}
```

## Currency

Get the currency information from your shop.

### Symbol

```markup
{{ currency }} // short syntax

{{ currency:symbol }}
```

Will return the currency symbol.

### Name

```markup
{{ currency:name }}
```

Will return the currency name

### Iso

```markup
{{ currency:iso }}
```

Will return the currency iso code

### Delimiter

```markup
{{ currency:delimiter }}
```

Will return the currency delimiter.  

## Products

### Products

```markup
{{ products }}
```

Will return all existing products.

