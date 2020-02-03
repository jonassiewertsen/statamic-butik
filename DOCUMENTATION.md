# Statamic Butik Documentation
![Statamic 3.0+](https://img.shields.io/badge/Statamic-3.0+-FF269E?style=for-the-badge&link=https://statamic.com)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/jonassiewertsen/statamic-butik.svg?style=flat-square)](https://packagist.org/packages/jonassiewertsen/statamic-butik)

## Beta

"Butik" is an addon for Statamic v3, which is in beta right now. Until Statamic v3 is in beta, you should be careful to use Butik in production. There can be breaking changes!

## Installation

### With the installation script

1. You can install the package via composer:
```bash
composer require jonassiewertsen/statamic-butik
```

2. Run the install command
```bash
php please butik:install
```

### Manual installation

Will follow soon

## General set up

Most of the steps have been taken care of by the installer. Those are the last modifications needed. 

Open the statamic-butik.php config file `config/butik.php`.

### Shop Information

Add your Shop name, the address, mail, phone etc.

Specifying your country does automatically set the country your customers can ship your products to.

### Mail

Insert your mail, where you want to receive order confirmations. 

### Useful links

Those are optional. 

Your mails will contain a useful links section at the buttom. Only if you want to. This could be a good spot to give your customer more information about your products, more shipping information, refund information etc ...


### Currency

Define your shop currency

### Routing

Do you want to rename the routes used by *Statamic Butik*? Feel free to change them here. 

### Layouts

To integrate your shop perfectly into your existing site, you can swap the layout used by *Statamic Butik*. 

Let's say you want to swap the layout for the product overview with your own layout file inside `resources/views/layouts/my-layout.antlers.html`

```
// before
'layout_product-overview' => 'butik::web.layouts.shop',

// after
'layout_product-overview' => 'layouts.my-layout',
```

The `butik::` prefix will ask Statamic, to look into the vendor files. If wanted, you can make some changes to the existing files inside `resources/views/vendor/statamic-butik/`. 
If you want to use your own files, remove the prefix to start inside the resources/views directory.

### Templates

They are precisely working as layouts.

### Payment

Don't make any changes to the payments inside the config file. Do so in your .env file

## Enviroment file

Your .env file should mostly be set up. To make sure you got it right, here comes an overview

```bash
# Remember to set your APP_ENV to something different then local, to work with webhooks.

# SQLite setup
DB_CONNECTION=sqlite
DB_FOREIGN_KEYS=true

# Remember to set up your mollie key
MOLLIE_KEY=xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

# In case you want to use redis for your queues
# remember to require predis/predis via composer
QUEUE_DRIVER=redis

# Get your email set up. Test it via the Statamic control panel
MAIL_DRIVER=smtp
MAIL_HOST=your.host.com
MAIL_PORT=XXX
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
```

## Translation

To add another language open the lang directory `resources/lang/vendor/statamic-butik/`

Make a copy of the en folder, rename it into your prefered language and change the translations in your newly created folder.

```
// before
'back' => 'back',

// for german translation
'back' => 'zurück'
```

Make sure NOT to delete the `en` directory. It is the fallback language and should not be deleted.

## Version controll your Database?

No Problem with SQLite! 

Go into your `database` directory and delete the .gitignore file in there. That's it. Git will track those changes now. 
