---
description: 'We provide a starter kit, so you don''t need to hassle with the setup.'
---

# Starter Kit

## Get your Starter Kit

```text
git clone git@github.com:jonassiewertsen/statamic-butik-starter-kit.git butik
cd butik
rm -rf .git
composer install
cp .env.example .env && php artisan key:generate
```

{% hint style="success" %}
Everything has been set up
{% endhint %}

**Line 1**: This will clone the repo onto your computer inside the folder `butik`  
**Line 2**: Go into the new created folder  
**Line 3**: Remove the github folder   
**Line 4**: Install all dependencies  
**Line 5**: Create your .env file and generate a fresh key

## Create a user

```text
php please make:user
```

Make it a superuser if you want to grant overall access.

More information: [Statamic documentation](https://statamic.dev/users)

## **Recompile CSS**

{% hint style="info" %}
This step is optional.
{% endhint %}

The [TailwindCSS](https://tailwindcss.com/) included in this kit is compiled with [PurgeCSS](https://purgecss.com/) to reduce filesize on any unused classes and selectors. If you want to modify anything, just recompile it.

```text
npm i && npm run dev
```

To compile for production:

```text
npm run production
```

## Next Steps

### Open your page

If you're using [Laravel Valet](https://laravel.com/docs/valet) \(or similar\), your site should be available at `http://butik.test`. 

You can access the control panel to edit your shop at `http://butik.test/cp` . Login with your new user to do so. 

### Configure your shop

The next step is the configuration of your shop.

{% page-ref page="../../configuration/configuration.md" %}

### Make it yours

Use our preset design or customize it according to your needs.

{% page-ref page="../../frontend/templates/" %}

### Enjoy

We hope you will have a postive experience using _butik_ and enjoy its results. 

### Having trouble?

[Get in touch](https://butik.dev/#reach-out)

