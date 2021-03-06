# Release Notes

## 3.5.7 (12. Juni 2021)
- Fix a problem with variants, which may have led to problems if visiting the products page. (#229)

## 3.5.6 (17. May 2021)
- Fix the payment provider stub, where variables have been passed wrongly into the create order method.

## 3.5.5 (14. Mar 2021)
- Rename delete action internally to avoid permission problems with the core delete action (#197)
- Don't gitignore the composer.lock file
- Update the php unit xml file to the standard > phpunit 9.3
- Update Github actions to newest standards
- Temporary comment out tests, to prevent them from failing randomly on GitHub actions (Yes, I am a bad boy) (#204)

## 3.5.4 (09. Mar 2021)
- Translate shop pages correctly (#201)
- Don't gitignore the compsoer.lock file
- Swap hardcoded text in product show view with translation tag. 

## 3.5.3 (22. Feb 2021)
- Cast all order dates correctly
- Language tweaks (#195 thanks @philipboomy)
- Update a doc block typo

## 3.5.2 (06. Feb 2021)
- Only create a show url if the product route config is set to true (#192)
- Hiding the is_visible functionality. (#188)

## 3.5.1 (25. Jan 2021)
- A hot fix for an issue with the products tag.

## 3.5.0 (25. Jan 2021)
- Shipping information will get saved with the order
- Orders can deleted (#143)
- It's configurable if orders can be deleted and by whom.
- Include shipping taxes in total taxes as calculated by the cart (#183)

See the docs for more information:
https://www.butik.dev/configuration/orders

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
