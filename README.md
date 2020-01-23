# Statamic Butik - Ecommerce solution

[![Latest Version on Packagist](https://img.shields.io/packagist/v/jonassiewertsen/statamic-butik.svg?style=flat-square)](https://packagist.org/packages/jonassiewertsen/statamic-butik)

"Butik" is a Scandinavian term for a small or medium-sized shop. Exactly what this Statamic addon has been crafted for.

It is my goal to create a wonderful e-commerce solution, for small to medium-sized online shops.

"Butik" is an addon for Statamic v3, which is in Beta right now. Until Statamic v3 is in beta, you should be really careful to use Butik in production. There can be breaking changes!

## Functionality

"Butik" will gain a lot more functionality over the next weeks, but i wanted to share it already to get it tested and to get some feedback fromo the community.
Right now it is the most basic shop you can image, but well tested!

There are nearly 200 tests in place, to make sure that every thing runs as expected. Great, isn't it?

- Create Products
- Add Taxes
- Add Shipping
- Express Checkout
- All templates customizable

## Payment 

- PayPal
- Credit Cards

All payments will be handled via mollie.com

## How does it look

## Installation

1. You can install the package via composer:
```bash
ADD TO PACKAGIST
```

2. Run the install command
```bash
php please butik:install
```
This will run you through the setup process. If you don't want to use SQLite, feel free to choose the database of your Choise. MySql would be a good choise as well.
Because Statamic is a flat file cms ... bla bla

3. Disable CSRF for one specific route
Go inside the root of your Laravel application and from there:
```bash
app / Http / Middleware / VerifyCsrfToken.php
```
After adding the webhook route, it should look like following
```bash
protected $except = [
    'payment/webhook/mollie'
];
```

4. Configure your mail settings, as described in the Statamic docs to make sure, that Butik can send mails to you and your customers.



## License

The The Unlicense. Please see [License File](LICENSE.md) for more information.