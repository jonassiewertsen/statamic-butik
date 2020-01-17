import ProductListing from './components/products/Listing';
import TaxesListing from './components/taxes/Listing';
import ShippingListing from './components/shippings/Listing';

Statamic.booting(() => {
    Statamic.$components.register('butik-product-list', ProductListing);
    Statamic.$components.register('butik-tax-list', TaxesListing);
    Statamic.$components.register('butik-shipping-list', ShippingListing);
});
