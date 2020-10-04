---
description: Those are the basic and most important settings to make.
---

# Config File

## Shop information

Those information will mostly be used for view or email templates.

```text
'name'     => 'Statamic Butik',
'address1' => '132 Main Street',
'address2' => 'Sea view, Fahrensodde', 
'zip_city' => '24937 Flensburg',
'country'  => 'DE',
'phone'    => '+49 1294 238474934',
'mail'     => 'butik@shop.com',
```

{% hint style="info" %}
 You need to define your country via an alpha-2 iso code.  
[https://en.wikipedia.org/wiki/ISO\_3166-1\_alpha-2\#Officially\_assigned\_code\_elements](https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2#Officially_assigned_code_elements)
{% endhint %}

The defined country will be set as your default country. As long as a user does not select another country in the checkout process, all shipping prices will be calculated on the basis of the default country.

## Shop overview

```text
'overview_type'    => 'newest',
'overview_limit'   => '6',
```

What do you want butik to show on the overview page; the entry point for your shop?

{% hint style="info" %}
By default, the shop entry point will be `/shop`
{% endhint %}

| Options | Description |
| :--- | :--- |
| **all** | All products ordered by name. The limit will be ignored. |
| **name** | All products ordered by name. The limit will be respected. |
| **newest** | Showing the latest added products. |
| **cheapest** | Showing products with the lowest price first. |

The overview limit does only limit the number of products shown on the shop overview page.

## Mail

```text
'order-confirmations' => 'your_mail@butik.com',
```

Butik will send one confirmation e-mail for every sold product. You can define the address right here.

{% hint style="info" %}
You need to set up your mails with Statamic correctly, before butik can successfully notify you. 
{% endhint %}

See the [Statamic documentation](https://statamic.dev/email) for more information. You can easily send yourself a test mail from the control panel to confirm that you mail is working as expected.

## Currency

```text
'currency_name'      => 'Euro',
'currency_isoCode'   => 'EUR',
'currency_symbol'    => '€',
'currency_delimiter' => ',',
```

Choose the currency of your default country. 

Please keep the currency\_isoCode strict to the ISO 4217 standard. That's just a fancy name for the know currency syntax:  
[https://en.wikipedia.org/wiki/ISO\_4217](https://en.wikipedia.org/wiki/ISO_4217)  


## Widgets

```text
'widget_orders-limit' => 10,
```

The default is set to 10 entries. If you do use the _Orders_ widget and want to regulate the number of orders shown, please do so. 

## Routing

```text
'shop_route_active'     => true,
'product_route_active'  => true, 
'category_route_active' => true,

'route_shop-prefix'       => 'shop',                      
'route_cart'              => 'cart',            
'route_category'          => 'category/{category}',     // keep {category}         
'route_checkout-delivery' => 'checkout/delivery',          
'route_checkout-payment'  => 'checkout/payment',           
'route_payment-receipt'   => 'payment/{order}/receipt', // keep {order}
```

We made it easy to configure all standard routes. This could be handy in case you want localized routes.

There may be cases where you don't want to use our default routes to view the shop, the product or categories. Set them to false to deactivate those routes.

## Layouts

```text
'layout_product-index'            => 'layout',
'layout_product-category'         => 'layout',
'layout_product-show'             => 'layout',
'layout_cart'                     => 'layout',
'layout_checkout-delivery'        => 'layout',
'layout_checkout-payment'         => 'layout',
'layout_checkout-receipt'         => 'layout',
'layout_checkout-receipt-invalid' => 'layout',
```

We will default to the standard layout in your `resources/views/` folder. Move and/or change the layout file as you need it and define it here. _Butik_ will take of the rest.

## Template

```text
'template_product-index'            => 'butik::web.shop.index',
'template_product-category'         => 'butik::web.shop.category',
'template_product-show'             => 'butik::web.shop.show',
'template_cart'                     => 'butik::web.cart.index',
'template_checkout-delivery'        => 'butik::web.checkout.delivery',
'template_checkout-payment'         => 'butik::web.checkout.payment',
'template_checkout-receipt'         => 'butik::web.checkout.receipt',
'template_checkout-receipt-invalid' => 'butik::web.checkout.invalid-receipt',
```

We put a lot of effort into the creation of our default templates to get you started as quick as possible.

The files will automatically be stored inside `resources/views/vendor/butik`.   
You can move those files or create your own. 

If you want to link to a file named cart inside your `resources/views/shop/cart.blade.php` folder, the updated path would be `shop.cart` without the prefix `butik::`

 [Mike Martin](https://mike-martin.ca/) created our beautiful templates.

## Shipping

```text
'shipping' => [
    'price' => \Jonassiewertsen\StatamicButik\Shipping\ShippingByPrice::class,
],
```

If you want, you can implement your own shipping methods or disable those, you don't want to use.

{% page-ref page="../extending/shipping.md" %}

## Payment Gateway

```text
'payment_gateway' => Jonassiewertsen\StatamicButik\Http\Controllers\PaymentGateways\MolliePaymentGateway::class,
```

Out of the box, _butik_ does implement [Mollie](www.mollie.com/en) as our payment provider of choice, which is ready to use. 

You can easily swap our implementation with your own.

{% page-ref page="../extending/payment-gateway.md" %}



