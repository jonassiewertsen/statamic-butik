import ProductListing from './components/products/Listing';
import CountryListing from './components/countries/Listing';
import TaxesListing from './components/taxes/Listing';
import OrdersListing from './components/orders/Listing';

import ShippingOverview from "./components/shipping/Overview";

import ProductCategories from "./components/categories/ManageProductCategories";
import ProductVariants from "./components/variants/ManageProductVariants";

import MoneyFieldtype from './components/fieldtypes/moneyFieldtype';
import TaxFieldtype from './components/fieldtypes/taxFieldtype';

import CreateButton from './partials/CreateButton';
import PublishFormRedirect from './partials/PublishFormRedirect';

Statamic.booting(() => {
    // Listings
    Statamic.$components.register('butik-product-list', ProductListing);
    Statamic.$components.register('butik-country-list', CountryListing);
    Statamic.$components.register('butik-tax-list', TaxesListing);
    Statamic.$components.register('butik-order-list', OrdersListing);

    Statamic.$components.register('butik-shipping-overview', ShippingOverview);

    Statamic.$components.register('butik-manage-product-categories', ProductCategories);
    Statamic.$components.register('butik-manage-product-variants', ProductVariants);

    // Fieldtypes
    Statamic.$components.register('money-fieldtype', MoneyFieldtype);
    Statamic.$components.register('tax-fieldtype', TaxFieldtype);

    // Partials
    Statamic.$components.register('create-button', CreateButton);
    Statamic.$components.register('publish-form-redirect', PublishFormRedirect);
});
