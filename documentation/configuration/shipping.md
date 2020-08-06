# Shipping

Your shipping settings can be kept simple or really complex if you need them to be. 

![Edit your shipping settings in the control panel.](../.gitbook/assets/shipping-menu.png)

## Shipping Profiles

A shipping profile is the connection between your product and the calculation of the shipping price. You need to choose one shipping profile for each product.

![The standard profile will be created as default.](../.gitbook/assets/shipping-profile-overview.png)

Each shipping profile has it's own [shipping zones](https://butik.dev/configuration/shipping#shipping-zones) and [rates](https://butik.dev/configuration/shipping#shipping-rates). This gives you the flexibility to decide where your products can be purchased and what you need and want to charge for shipping.

{% hint style="success" %}
You only need one profile. 
{% endhint %}

### Use case 1: T-Shirt shop

Let's assume you own a shop, only selling T-shirts. The got different colors, sizes and prices, but the shipping costs are the same per T-Shirt. 

No need for more than one Shipping profile. 

### Use case 2: Surf shop

A surf shop might sell T-shirts with the same shipping requirements as the T-shirt shop, but what if they want to sell surfboards also?

Surfboards are fragile but heavy goods and need a special kind of shipping which is much more expensive.

In that case, a second shipping profile named »Fragile« might be handy, so you can differentiate between »standard t-shirt« and »fragile surfboard« shipping. You can charge different prices for shipment and restrict the countries you are selling them to easily.

##  Shipping Zones

Shipping zones are grouping countries, to save yourself a lot of time and making managing different zones easier.

This shipping profile has two shipping zones.

| Zone name |  |
| :--- | :--- |
| **Germany** | Only containing one country, which often might be your home or default country to ship to. |
| **Scandinavia** | Does contain Denmark, Sweden and Norway assuming the shipping costs are nearly the same in each country.  |

As you can see, we defined different shipping costs for these zones. 

![Define your shipping zones according to your needs.](../.gitbook/assets/manage-shipping-zones.png)

### Connect countries

To edit a shipping zone, you'll find the edit symbol beside the shipping zone name.

![Will be blue on hover.](../.gitbook/assets/edit-shipping-zone.png)

This is the place to connect or disconnect existing countries to your shipping zone.

![Nice toggle buttons.](../.gitbook/assets/manage-shipping-zone.png)

{% hint style="info" %}
Every country can only be connected to one shipping zone per shipping profile. 

_butik_ will let you know if you're trying otherwise. 
{% endhint %}

### Use case 1: T-Shirt shop

The connected countries in the image above \(Denmark, Sweden and Norway\) might make sense if you want to ship to scandinavia. 

Germany might be excluded, because having it's own shipping zone. France might be excluded, because you don't want to sell to France right now or the shipment costs vary greatly.

### Use case 2: Surf shop

Selling surfboards abroad might be really expensive and complicated. In that case, you might want to create one shipping profile including only your home country. 

{% hint style="success" %}
_butik_ will show your users automatically through the checkout process if they can't buy certain items. 
{% endhint %}

## Shipping Rates

Easily create, edit or delete shipping rates. 

It's a common use case to charge for shipping, unless your customers buy for at least amount X. 

![Shipping rates might look similar to this.](../.gitbook/assets/manage-shipping-zones.png)

You can name your shipping rates as you prefer.

### Use case 1: Germany

| Rate |  |
| :--- | :--- |
| **Standard** | With a minimum amount of zero, this is the first shipping rate applying automatically. Your customers will be charged 12 in total. |
| **Free** | As soon as all products in the shopping bag do exceed to a minimum amount of 50, your customers will get free shipping. |

### Use case 2: Scandinavia

The system is the same as for Germany, besides the shipping cost for your customer starts at a product value of 30.

As soon as somebody is buying items for more than 80 in total, the free shipping costs will apply as well.

### Buying items from different shipping profiles

{% hint style="info" %}
The calculated shipping costs will be separated by their belonging shipping profiles. 
{% endhint %}

What does that mean?

**Let's go back to our surf shop example:**  
A customer could buy so many t-shirts, that shipping would be free for all of them. 

By adding a surfboard to his shopping bag, which does belong to another shipping profile, he will probably pay shipping costs for it. 

The shipping costs for his t-shirts would be free, but he has to pay shipping for his surfboard only.

