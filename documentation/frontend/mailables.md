---
description: Customize your emails
---

# Mailables

You can adjust our sent mails just as you like them. 

## Adjust your template

{% hint style="danger" %}
Unfortunately there is an issue if using markdown at the moment. You can easily adjust it though. I will explain how.
{% endhint %}

See the issue: [https://github.com/statamic/cms/issues/2747](https://github.com/statamic/cms/issues/2747)

### 1. Publish your vendor files

```text
php artisan vendor:publish --tag=laravel-mail
```

Docs for more information: [https://laravel.com/docs/master/notifications\#customizing-the-components](https://laravel.com/docs/master/notifications#customizing-the-components)

### 2. Create your own theme

Duplicate the `default.css` file and rename yoru copy to for example `butik dd`  

You'll find the css file in the themes folder:

```text
resources/views/vendor/mail/html/themes
```

### 3. Change your theme

Update the `theme` option of the `mail` configuration file to match the name of your new theme inside your `config\mail.php`

In our example, you need to rename the theme to `butik`

That's it!

## Templates

[After publishing your views](https://www.butik.dev/installation/publishing-assets#views), you can adjust our mail templates. 

The following values are available inside the views:

| variable | includes |
| :--- | :--- |
| **$order** | All order information |
| **$customer** | Customer information |
| **$items** | The purchased items |
| **$order\_id** | The order ID |
| **$paid\_at** | When the purchase has been paid |
| **$total\_amount** | The total amount |

### Customize markdown layout

You can customize the markdown as described in the [Laravel documentation](https://laravel.com/docs/8.x/mail#customizing-the-components).

