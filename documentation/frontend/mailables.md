---
description: Customize your emails
---

# Mailables

You can adjust our sent mails just as you like them. 

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

