import ProductListing from './components/products/Listing';
import TaxesListing from './components/taxes/Listing';

Statamic.booting(() => {
    Statamic.$components.register('butik-product-list', ProductListing);
    Statamic.$components.register('butik-tax-list', TaxesListing);
});
