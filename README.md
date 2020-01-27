# Statamic Butik - Statamic e-commerce solution
![Statamic 3.0+](https://img.shields.io/badge/Statamic-3.0+-FF269E?style=for-the-badge&link=https://statamic.com)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/jonassiewertsen/statamic-butik.svg?style=flat-square)](https://packagist.org/packages/jonassiewertsen/statamic-butik)

"Butik" is a Scandinavian term for a small to medium sized shop, precisely what this Statamic addon has been crafted for. 
The *Statamic Butik*  e-commerce solution will integrate nicely with your personal Statamic site and help to grow your online business.

You can use the light and simple design as shipped or customize it after your needs, to integrate it perfectly into your existing design.

# License 

Before going into productions with *Statamic Butik*, you need to buy a license at the Statamic Marketplace. 

*Statamic Butik* is not free software. 

# Beta

Addons haven't been fully integrated into Statamic v3 at the moment. To try Statamic Butik, you need to force your application to use the beta 11 version of Statamic.
You need to change your composer file like following.
```
"require": {
    ...
    "statamic/cms": "v3.0.0-beta.11"
}
```

Now run `composer update`.

"Butik" is an addon for Statamic v3, which is in beta right now. Until Statamic v3 is in beta, you **should be careful to use Butik in production. There can be breaking changes!**

## Stability

The actual version is backed up by **183 PHPUnit tests** with **473 assertions** to check if things are working as expected. 

With Butik it's my highest goal to provide a stable and fun to use e-commerce solution, build with a Scandinavian mindset:
Starting as simple as possible with the most stable foundation, to continue from there. Said so, keep in touch about the newest updates.

## Functionality

*This well tested Butik version will extend functionality over the next months!*

What Butik can do:

### INSTALLATION
- [x] You can use the installer, which is guiding you through most of the the process
- [x] For more control, you can set it up manually

### PRODUCTS with
- [x] SEO friendly URLs
- [x] taxes
- [x] shipping costs
- [x] stock (limited or unlimited)

### ORDERS
- [x] Keep easily track off all your orders
- [x] Optional orders widget for your dashboard

### Mails
- [x] Order confirmations for the customer
- [x] Order confirmations for the seller
- [x] Templates integrated with langualge files

### DESIGN
- [x] comes with a light and simple design, ready to use out of the box
- [x] layouts can be customized or swapped with your own
- [x] templates can be customized or swapped with your own
- [x] applies for email layouts & templates as well

### TRANSLATION
- [x] All frontend and backend designs have been integrated with language files. 
- [x] English as fallback language
- [x] Add easily new languages

### SETTINGS
- [x] Integrate your currency
- [x] Change all route names as you need them
- [x] Integrate useful links into your mail template
- [x] Swap layouts
- [x] swap templates

## Limitations 

If you need some functions, which Statamic Butik does not provide at the moment, get in contact.  The functionality will be extended a lot over the next months. 

- [ ] Express checkout only
- [ ] No product variations
- [ ] Shipping of physical products only inside your home country
- [ ] Only your home currency available

## Payment 

All payments will be handled by mollie.com and do offer
* PayPal
* Visa
* Mastercard
* Apple Pay
* Klarna
* American Express
* nand many more ...

**No monthly fees to use mollies.com.** You will be charged per transaction.

Mollies payment gateway does work with webhooks, which does provide security and a safe way to update a payment status. Even if the customer will close his tab right after the payment, he will get notified. 
Even if your website went down for many hours, all payments would be updated afterwards. 

## Links

- [Github issue tracking](https://github.com/jonassiewertsen/statamic-butik)
- [Share your ideas & wishes with me](https://feedback.userreport.com/81c07a00-5ad7-4f63-b28d-503c3a76bfdc/)
