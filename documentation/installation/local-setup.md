---
description: How to set up your local dev environment.
---

# Dev Setup

## E-mails

There a multiple options to test your e-mails locally. 

One popular option is [Mailtrap](https://mailtrap.io/).

## Webhooks

Remember to define the [csrf exception](https://butik.dev/installation/untitled#allow-webhooks)

{% page-ref page="../configuration/configuration.md" %}

## Payment process

{% hint style="warning" %}
This step is only nessesarry if you want to test the mollie payment provider **locally**.
{% endhint %}

Working with a staging server online? Not needed.  
No need to test the last payment step locally? Not needed.

### Ngrok / Valet share

[Mollie](https://docs.mollie.com/guides/webhooks) does communicate via a webhook with the _butik_ application. After creating a payment, mollie will send the answer via webhook. 

```text
APP_ENV=local
MOLLIE_NGROK_REDIRECT=https://your_url.ngrok.io
```

Define your redirect url in your .env and Mollie does know how to reach your local environment. 

Paste your url witthout`/` at the end. 

#### Laravel Valet

You can simply share your site via Valet. Past the url into your .env file. That's it.   
[Information about Laravel Valet](https://laravel.com/docs/7.x/valet#sharing-sites)

{% hint style="warning" %}
For security reasons, your `APP_ENV` must be set to `local.`The redirect url will be ignored in none local environments. 
{% endhint %}

