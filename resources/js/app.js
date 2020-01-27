import ProductListing from './components/products/Listing';
import ShippingListing from './components/shippings/Listing';
import TaxesListing from './components/taxes/Listing';
import OrdersListing from './components/orders/Listing';

import MoneyFieldtype from './components/fieldtypes/moneyFieldtype';

Statamic.booting(() => {
    // Listings
    Statamic.$components.register('butik-product-list', ProductListing);
    Statamic.$components.register('butik-shipping-list', ShippingListing);
    Statamic.$components.register('butik-tax-list', TaxesListing);
    Statamic.$components.register('butik-order-list', OrdersListing);

    // Fieldtypes
    Statamic.$components.register('money-fieldtype', MoneyFieldtype);
});
