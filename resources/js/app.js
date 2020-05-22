import ProductListing from './components/products/Listing';
import ShippingListing from './components/shippings/ShippingProfile';
import CountryListing from './components/countries/Listing';
import TaxesListing from './components/taxes/Listing';
import OrdersListing from './components/orders/Listing';

import ShippingProfile from "./components/shippings/ShippingProfile";

import MoneyFieldtype from './components/fieldtypes/moneyFieldtype';
import TaxFieldtype from './components/fieldtypes/taxFieldtype';

Statamic.booting(() => {
    // Listings
    Statamic.$components.register('butik-product-list', ProductListing);
    Statamic.$components.register('butik-shipping-list', ShippingListing);
    Statamic.$components.register('butik-country-list', CountryListing);
    Statamic.$components.register('butik-tax-list', TaxesListing);
    Statamic.$components.register('butik-order-list', OrdersListing);

    Statamic.$components.register('butik-shipping-profile', ShippingProfile);

    // Fieldtypes
    Statamic.$components.register('money-fieldtype', MoneyFieldtype);
    Statamic.$components.register('tax-fieldtype', TaxFieldtype);
});
