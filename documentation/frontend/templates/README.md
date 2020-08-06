# Templates

## Customizing routes

We will show our default route and the template path at the top of every template page to give you a better orientation. For example:

```bash
 yourshop.com/shop/payment/xxxxx/receipt
 
 /checkout/payment.antlers.html
```

{% hint style="success" %}
Remember that you can customize all routes in your config file.
{% endhint %}

{% page-ref page="../../configuration/configuration.md" %}

## Publish templates

{% hint style="info" %}
Already set up in the Starter Kit.
{% endhint %}

To edit all template files, you need to publish them into your views directory.

```bash
php artisan vendor:publish --tag="butik-views"
```

{% page-ref page="../../installation/publishing-assets.md" %}

## Tags

Most templates come with some additional tags. We will eplain what you can expect.

{% hint style="success" %}
All tags are always available and can be used as well.
{% endhint %}

## Functionality

A lot of templates offer some extra functionality. We will document what you can expect.

