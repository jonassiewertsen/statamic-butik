---
description: >-
  For security reasons, you can define if orders can be deleted and if they can,
  from whom.
---

# Orders

## How to configure deletable orders

You can choose between 3 options.

{% hint style="info" %}
The default will be set to `development`
{% endhint %}

You can either set your choice in the [configuration file](configuration.md) or define it in your .env file:

```php
BUTIK_ORDERS_DELETABLE=development
```

## Options

Those are the states you can define:

| options | Description |
| :--- | :--- |
| **never** | Orders can't be deleted at all. |
| **development** | Orders can be deleted in development mode only. |
| **users** | Orders can be deleted by all users, if they got the correct Statamic permissions. |

### Never

This is the safest option and won't let you delete any orders.

### Development

You can delete orders in development [environment](https://laravel.com/docs/8.x/configuration#environment-configuration). To be more specific, you can delete orders as long as your environment is **not** set to production.

#### Example

```php
APP_ENV=local // You can delete orders

APP_ENV=production // You can't delete any orders
```

### Permissions

If set to permissions, every super admin can delete orders. Other users can delete orders as well, as long as they have the right permissions. 

Make sure to set those permissions for the users you want to allow deleting orders.

{% hint style="danger" %}
Consider carefully if you want to allow deleting orders in production. It's **not** recommended. 
{% endhint %}

