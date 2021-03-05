<?php

namespace Jonassiewertsen\StatamicButik\Checkout;

use Facades\Jonassiewertsen\StatamicButik\Http\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Jonassiewertsen\StatamicButik\Contracts\CartRepository;
use Jonassiewertsen\StatamicButik\Facades\Price;
use Jonassiewertsen\StatamicButik\Shipping\Country;
use Jonassiewertsen\StatamicButik\Shipping\Shipping;

class Cart implements CartRepository
{
    public $cart;
    private $totalShipping;
    private $totalTaxes;

    public function __construct()
    {
        $this->cart = Session::get('butik.cart') ?? collect();
    }

    public function __desctruct()
    {
        $this->save();
    }

    public function get(): Collection
    {
        return $this->cart;
    }

    /**
     * A product can be added to the cart.
     */
    public function add(string $slug, int $quantity = 1, ?string $locale = null): void
    {
        if ($this->contains($slug)) {
            // increase the quantity
            $this->cart->firstWhere('slug', $slug)->increase();
        } else {
            // Add new Item
            $this->cart->push(new Item($slug, $locale ?? locale()));
        }
    }

    /**
     * An item can be reduced or removed from the cart.
     */
    public function reduce($slug): void
    {
        $this->cart = $this->cart->filter(function ($item) use ($slug) {
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
    }

    /**
     * An item can be completly removed from the cart.
     */
    public function remove($slug): void
    {
        $this->cart = $this->cart->filter(function ($item) use ($slug) {
            return $item->slug !== $slug;
        });
    }

    /**
     * Clear the complete cart.
     */
    public function clear(): void
    {
        $this->cart = collect();
    }

    /**
     * Fetch the customer from the session.
     */
//    public static function customer(): ?Customer
//    {
//        return Session::get('butik.customer') !== null ?
//            Session::get('butik.customer') :
//            null;
//    }

    /**
     * The total count of items.
     */
    public function count()
    {
        return $this->cart->map(function ($item) {
            return $item->getQuantity();
        })->sum();
    }


    public function totalPrice()
    {
        $amount = Price::of(0);

        $this->cart->each(function ($item) use ($amount) {
            if (! $item->sellable) {
                return; // We won't charge for non sellable items
            }

            $amount->add($item->totalPrice());
        });

//        return $amount->add(static::totalShipping())->get();
        return $amount->add(0)->get();
    }

//
//    /**
//     * All taxes from products and shipping.
//     */
//    public static function totalTaxes(): Collection
//    {
//        static::$totalTaxes = collect();
//        $taxRates = [];
//
//        /**
//         * Return an empty collection in case the cart is empty.
//         */
//        if (! static::$cart) {
//            return collect();
//        }
//
//        /**
//         * Collecting all item tax rates.
//         */
//        foreach (static::$cart as $item) {
//            if (! in_array($item->taxRate, $taxRates)) {
//                $taxRates[] = $item->taxRate;
//            }
//        }
//
//        /**
//         * Add all tax rates on top from our shippings.
//         */
//        foreach (static::shipping() as $shipping) {
//            if (! in_array($shipping->taxRate, $taxRates)) {
//                $taxRates[] = $shipping->taxRate;
//            }
//        }
//
//        /**
//         * We will loop through all tax rates and sum the amounts.
//         */
//        foreach ($taxRates as $taxRate) {
//            $totalTaxAmount = static::$cart
//                ->where('taxRate', $taxRate)->map(function ($item) {
//                    return Price::of($item->taxAmount)->cents();
//                })->sum();
//
//            // On top of that we need to add the tax amounts from our shipping rates
//            if ($shipping = static::shipping()->firstWhere('taxRate', $taxRate)) {
//                $totalTaxAmount += Price::of($shipping->taxAmount)->cents();
//            }
//
//            $totalTaxAmount = Price::of($totalTaxAmount)->delimiter(config('butik.currecny_delimiter', ','))->get();
//
//            // In case there is a product or shipping with an tax rate, but with an amount of zero, we will
//            // return early to not push the to the total taxes collection.
//            if ($totalTaxAmount === '0,00') {
//                continue;
//            }
//
//            // For better access in antlers views, the amount and rate will get added as an array.
//            static::$totalTaxes->push([
//                'amount' => $totalTaxAmount,
//                'rate'   => $taxRate,
//            ]);
//        }
//
//        return static::$totalTaxes;
//    }
//
//    /**
//     * All shipping costs are seperated into the original
//     * shipping profiles, where they came from.
//     */
//    public static function shipping(): Collection
//    {
//        $shipping = new Shipping(static::get());
//        $shipping->handle();
//
//        return $shipping->amounts;
//    }
//
//    /**
//     * All shipping costs, from all shipping profiles, summed
//     * up to determine the total shipping costs.
//     */
//    public static function totalShipping(): string
//    {
//        static::resetTotalShipping();
//
//        static::shipping()->each(function ($shipping) {
//            static::$totalShipping += Price::of($shipping->total)->cents();
//        });
//
//        return Price::of(static::$totalShipping)->get();
//    }
//
//    /**
//     * Update the shopping cart.
//     */
//    public static function update()
//    {
//        static::$cart = static::get();
//
//        $items = static::$cart->filter(function ($item) {
//            return Product::exists($item->slug) && $item->update();
//        });
//
//        static::set($items);
//    }
//
//    /**
//     * Getting the actual choosen country.
//     */
//    public static function country()
//    {
//        return Country::get();
//    }
//
//    /**
//     * Set a different country to checkout to.
//     */
//    public static function setCountry(string $code): void
//    {
//        Country::set($code);
//        static::totalPrice();
//    }

    public function removeNonSellableItems(): void
    {
        $this->cart = $this->cart->filter(function ($item) {
            return $item->sellable;
        });
    }

//    /**
//     * An empty cart.
//     *
//     * @return Collection
//     */
//    private static function empty(): Collection
//    {
//        return collect();
//    }

    /**
     * Is the product already saved in the cart?
     */
    private function contains(string $slug): bool
    {
        return $this->cart->contains('slug', $slug);
    }

    /**
     * Set the cart to the session.
     */
    private function save(): void
    {
        Session::put('butik.cart', $this->cart);
    }
}
