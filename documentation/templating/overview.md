# Overview

_butik_ has been crafted with a default design, so everybody does have great base to start from. 

No starting from scratch everytime, no need to set up a lot of routes etc.   
Just get started!

## Customization

We are trying to find the perfect balance between »just working« and »fully customizable«. 

Said so, we have prepared a lot of boilerplate which can be easily shared. 

## Starter Kit

Our provided Starter Kit does give you a great possibility to get started. 

{% page-ref page="../installation/installation/starter-kit.md" %}

## Implement CSS

{% hint style="info" %}
Not needed, if you are using our Starter Kit
{% endhint %}

If you want to use our design exactly as it is, feel free to do so. We would be happy to hear that others are liking it that much!

We did create it with [Tailwind CSS](https://tailwindcss.com/). You can either compile it yourself via Tailwind or use our css file as a standalone solution.

### Use compiled CSS file

You can include our compiled CSS file into the `<head>` section of your layout file. That's it.

```text
<link rel="stylesheet" href="/vendor/butik/css/statamic-butik.css">
```

### Compile it yourself

Have a look at our Starter Kit and how we did set it up. It's a basic Tailwind CSS set up, as you know it from [Statamic](www.Statamic.com). 

To recompile, run `npm run production`

## Templates

We do offer finished templates for every page, which already have been connected to all needed functionality. 

{% page-ref page="templates.md" %}

{% hint style="success" %}
Don't worry, you can change every bit of our templates.
{% endhint %}

## Antlers Tags

You can use [Antlers](https://statamic.dev/antlers) tags to integrate butik perfectly into your page. 

{% page-ref page="antlers-tags.md" %}

