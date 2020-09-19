import TaxesListing from './components/taxes/Listing';
import OrdersListing from './components/orders/Listing';

import ShippingOverview from "./components/shipping/Overview";

import ProductCategories from "./components/categories/ManageProductCategories";
import ProductVariants from "./components/variants/ManageProductVariants";

import MoneyFieldtype from './fieldtypes/moneyFieldtype';
import NumberFieldtype from './fieldtypes/numberFieldtype';
import ShippingFieldtype from './fieldtypes/shippingFieldtype';
import TaxFieldtype from './fieldtypes/taxFieldtype';
import VariantsFieldtype from './fieldtypes/variantsFieldtype';

import CreateButton from './partials/CreateButton';
import PublishFormRedirect from './partials/PublishFormRedirect';

Statamic.booting(() => {
    // Listings
    Statamic.$components.register('butik-tax-list', TaxesListing);
    Statamic.$components.register('butik-order-list', OrdersListing);

    Statamic.$components.register('butik-shipping-overview', ShippingOverview);

    Statamic.$components.register('butik-manage-product-categories', ProductCategories);
    Statamic.$components.register('butik-manage-product-variants', ProductVariants);

    // Fieldtypes
    Statamic.$components.register('money-fieldtype', MoneyFieldtype);
    Statamic.$components.register('number-fieldtype', NumberFieldtype);
    Statamic.$components.register('shipping-fieldtype', ShippingFieldtype);
    Statamic.$components.register('tax-fieldtype', TaxFieldtype);
    Statamic.$components.register('variants-fieldtype', VariantsFieldtype);

    // Partials
    Statamic.$components.register('create-button', CreateButton);
    Statamic.$components.register('publish-form-redirect', PublishFormRedirect);
});
