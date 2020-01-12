import ProductListing from './components/products/Listing';

Statamic.booting(() => {
    Statamic.$components.register('butik-product-list', ProductListing);
});
