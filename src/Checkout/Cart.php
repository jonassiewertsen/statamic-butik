<?php

namespace Jonassiewertsen\StatamicButik\Checkout;

use Facades\Jonassiewertsen\StatamicButik\Http\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Jonassiewertsen\StatamicButik\Facades\Price;
use Jonassiewertsen\StatamicButik\Shipping\Country;
use Jonassiewertsen\StatamicButik\Shipping\Shipping;

class Cart
{
    public static $cart;
    private static $totalPrice;
    private static $totalShipping;
    private static $totalTaxes;
    private static $totalItems;

    /**
     * A product can be added to the cart.
     */
    public static function add(string $slug, ?string $locale = null): void
    {
        static::$cart = static::get();

        if (self::contains($slug)) {
            // increase the quantity
            static::$cart->firstWhere('slug', $slug)->increase();
        } else {
            // Add new Item
            static::$cart->push(new Item($slug, $locale ?? locale()));
        }
        static::set(static::$cart);
    }

    /**
     * Fetch the cart from the session.
     */
    public static function get(): Collection
    {
        return Session::get('butik.cart') !== null ?
            Session::get('butik.cart') :
            static::empty();
    }

    /**
     * Fetch the customer from the session.
     */
    public static function customer(): ?Customer
    {
        return Session::get('butik.customer') !== null ?
            Session::get('butik.customer') :
            null;
    }

    /**
     * Clear the complete cart.
     */
    public static function clear(): void
    {
        static::set(static::empty());
    }

    /**
     * An item can be reduced or removed from the cart.
     */
    public static function reduce($slug): void
    {
        static::$cart = static::get();

        static::$cart = static::$cart->filter(function ($item) use ($slug) {
            // If the quantity is <= 1 the item will be deleted from the cart
            if ($item->slug === $slug && $item->getQuantity() <= 1) {
                return false;
            }

            // If the quantity is bigger than one, it will only decrease
            if ($item->slug === $slug && $item->getQuantity() > 1) {
                $item->decrease();

                return true;
            }

            // If the slug is not matching, we should not care and just
            // keep the item in our cart
            return true;
        });

        static::set(static::$cart);
    }

    /**
     * An item can be completly removed from the cart.
     */
    public static function remove($slug): void
    {
        static::$cart = static::get();

        static::$cart = static::$cart->filter(function ($item) use ($slug) {
            return $item->slug !== $slug;
        });

        static::set(static::$cart);
    }

    /**
     * The total count of items.
     */
    public static function totalItems()
    {
        static::$cart = static::get();
        static::resetTotalItems();

        static::$cart->each(function ($item) {
            static::$totalItems += $item->getQuantity();
        });

        return static::$totalItems;
    }

    /**
     * The total price of the complete cart.
     */
    public static function totalPrice()
    {
        static::$cart = static::get();
        static::resetTotalPrice();

        static::$cart->each(function ($item) {
            if (! $item->sellable) {
                // We won't charge for non sellable items
                return;
            }

            static::$totalPrice += Price::of($item->totalPrice())->cents();
        });

        // Adding the shipping costs to the total price
        $total = static::$totalPrice + Price::of(static::totalShipping())->cents();

        return Price::of($total)->get();
    }

    /**
     * All taxes from products and shipping.
     */
    public static function totalTaxes(): Collection
    {
        static::$totalTaxes = collect();
        $taxRates = [];

        /**
         * Return an empty collection in case the cart is empty.
         */
        if (! static::$cart) {
            return collect();
        }

        /**
         * Collecting all item tax rates.
         */
        foreach (static::$cart as $item) {
            if (! in_array($item->taxRate, $taxRates)) {
                $taxRates[] = $item->taxRate;
            }
        }

        /**
         * Add all tax rates on top from our shippings.
         */
        foreach (static::shipping() as $shipping) {
            if (! in_array($shipping->taxRate, $taxRates)) {
                $taxRates[] = $shipping->taxRate;
            }
        }

        /**
         * We will loop through all tax rates and sum the amounts.
         */
        foreach ($taxRates as $taxRate) {
            $totalTaxAmount = static::$cart
                ->where('taxRate', $taxRate)->map(function ($item) {
                    return Price::of($item->taxAmount)->cents();
                })->sum();

            // On top of that we need to add the tax amounts from our shipping rates
            if ($shipping = static::shipping()->firstWhere('taxRate', $taxRate)) {
                $totalTaxAmount += Price::of($shipping->taxAmount)->cents();
            }

            $totalTaxAmount = Price::of($totalTaxAmount)->get();

            // In case there is a product or shipping with an tax rate, but with an amount of zero, we will
            // return early to not push the to the total taxes collection.
            if ($totalTaxAmount === '0,00') {
                continue;
            }

            // For better access in antlers views, the amount and rate will get added as an array.
            static::$totalTaxes->push([
                'amount' => $totalTaxAmount,
                'rate'   => $taxRate,
            ]);
        }

        return static::$totalTaxes;
    }

    /**
     * All shipping costs are seperated into the original
     * shipping profiles, where they came from.
     */
    public static function shipping(): Collection
    {
        $shipping = new Shipping(static::get());
        $shipping->handle();

        return $shipping->amounts;
    }

    /**
     * All shipping costs, from all shipping profiles, summed
     * up to determine the total shipping costs.
     */
    public static function totalShipping(): string
    {
        static::resetTotalShipping();

        static::shipping()->each(function ($shipping) {
            static::$totalShipping += Price::of($shipping->total)->cents();
        });

        return Price::of(static::$totalShipping)->get();
    }

    /**
     * Update the shopping cart.
     */
    public static function update()
    {
        static::$cart = static::get();

        $items = static::$cart->filter(function ($item) {
            return Product::exists($item->slug) && $item->update();
        });

        static::set($items);
    }

    /**
     * Getting the actual choosen country.
     */
    public static function country()
    {
        return Country::get();
    }

    /**
     * Set a different country to checkout to.
     */
    public static function setCountry(string $code): void
    {
        Country::set($code);
        static::totalPrice();
    }

    public static function removeNonSellableItems(): void
    {
        static::$cart = static::get();

        static::$cart = static::$cart->filter(function ($item) {
            return $item->sellable;
        });

        static::set(static::$cart);
    }

    /**
     * An empty cart.
     *
     * @return Collection
     */
    private static function empty(): Collection
    {
        return collect();
    }

    /**
     * Is this product already saved in the cart?
     *
     * @param Product $product
     * @return bool
     */
    private static function contains(string $slug): bool
    {
        return static::$cart->contains('slug', $slug);
    }

    /**
     * Set the cart to the session.
     */
    private static function set(Collection $cart): void
    {
        Session::put('butik.cart', $cart);
    }

    private static function resetTotalItems(): void
    {
        static::$totalItems = 0;
    }

    private static function resetTotalPrice(): void
    {
        static::$totalPrice = 0;
    }

    private static function resetTotalShipping(): void
    {
        static::$totalShipping = 0;
    }
}
