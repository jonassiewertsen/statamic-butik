<?php

namespace Jonassiewertsen\StatamicButik\Checkout;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Http\Traits\MoneyTrait;
use Jonassiewertsen\StatamicButik\Order\Tax;
use Jonassiewertsen\StatamicButik\Shipping\Country;
use Jonassiewertsen\StatamicButik\Shipping\Shipping;

class Cart
{
    use MoneyTrait;

    public static $cart;
    private static $totalPrice;
    private static $totalShipping;
    private static $totalTaxes;
    private static $totalItems;

    /**
     * A product can be added to the cart.
     */
    public static function add(string $slug): void
    {
        static::$cart = static::get();

        if (self::contains($slug)) {
            // increase the quanitity
            static::$cart->firstWhere('slug', $slug)->increase();
        } else {
            // Add new Item
            static::$cart->push(new Item($slug));
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

    public static function totalPrice()
    {
        static::$cart = static::get();
        static::resetTotalPrice();

        static::$cart->each(function ($item) {
            if (!$item->sellable) {
                // We won't charge for non sellable items
                return;
            }

            static::$totalPrice += static::makeAmountSaveableStatic($item->totalPrice());
        });

        // Adding the shipping costs to the total price
        $total = static::$totalPrice + static::makeAmountSaveableStatic(static::totalShipping());

        return static::makeAmountHumanStatic($total);
    }

    public static function totalTaxes(): Collection
    {
        static::$totalShipping = collect();
        $taxRates = [];

        /**
         * Return an empty collection in case the cart is empty.
         */
        if (!static::$cart) {
            return collect();
        }

        /**
         * Let's collect all tax rates first.
         */
        foreach (static::$cart as $item) {
            if (!in_array($item->taxRate, $taxRates)) {
                $taxRates[] = $item->taxRate;
            }
        }

        /**
         * We will loop through all tax rates and sum the amounts.
         */
        foreach ($taxRates as $taxRate) {
            $totalTaxAmount = static::$cart
                ->where('taxRate', $taxRate)->map(function ($item) {
                    return static::makeAmountSaveableStatic($item->taxAmount);
                })->sum();

            $totalTaxAmount = static::makeAmountHumanStatic($totalTaxAmount);

            // For better access in antlers views, the amount and rate will get added as an array.
            static::$totalShipping->push([
                'amount' => $totalTaxAmount,
                'rate'   => $taxRate,
            ]);
        }

        return static::$totalShipping;
    }

    /**
     * All shipping costs are seperated into the original
     * shipping profiles, where they came from.
     */
    public static function shipping(): Collection
    {
        $shipping = new Shipping(Cart::get());
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
            static::$totalShipping += static::makeAmountSaveableStatic($shipping->total);
        });

        return static::makeAmountHumanStatic(static::$totalShipping);
    }

    /**
     * Update the shopping cart.
     */
    public static function update()
    {
        static::$cart = static::get();

        $items = static::$cart->filter(function ($item) {
            return $item->update();
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
     *
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
