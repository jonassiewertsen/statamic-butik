# Release Notes

## Upcoming Release
- Shippings will be saved in the order. (#149)

## 3.4.1 (16. Jan 2021)
- Respect saved listing preferences on the orders overview. (#181)
- Add the missing translation attribute 'items count'.
- Make the categories menu responsive for mobile devices. (#171)
- Bumping the lowest Statamic requirment to version 3.0.38.
- Register filters via the newly added $scopes attribute.

## 3.4.0 (13. Jan 2021)
- A new and better overview for orders has been implemented. Orders can be reordered and searched.
- The orders overview UI does look a native collection overview

### Update
Does the folder `resources/lang/vendor/butik` exist? Please update your lang files and add:

```php
'completed_at' => 'Completed at',
'ordered_at' => 'Ordered at',
'order_completed_filter_label' => 'order:completed',
'order_failed_filter_label' => 'order:failed',
'order_paid_filter_label' => 'order:paid',
```

- Does the folder not exist? Don't worry at all :-)
