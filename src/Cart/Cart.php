<?php

namespace Jonassiewertsen\Butik\Cart;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Jonassiewertsen\Butik\Contracts\CartRepository;
use Jonassiewertsen\Butik\Contracts\PriceRepository;
use Jonassiewertsen\Butik\Facades\Country;
use Jonassiewertsen\Butik\Facades\Price;
use Jonassiewertsen\Butik\Facades\Product;
use Jonassiewertsen\Butik\Http\Responses\CartResponse;
use Jonassiewertsen\Butik\Shipping\Shipping;

class Cart implements CartRepository
{
    protected $cart;

    public function __construct()
    {
        $this->cart = Session::get('butik.cart') ?? [];
    }

    public function __desctruct()
    {
        Session::put('butik.cart', $this->cart);
    }

    public function get(): ItemCollection
    {
        return (new ItemCollection([]))->items($this->cart);
    }

    public function raw(): array
    {
        return $this->cart;
    }

    /**
     * A product can be added to the cart.
     */
    public function add(string $slug, int $quantity = 1, string|null $locale = null): CartResponse
    {
        if ($this->contains($slug)) {
            $quantity = $this->cart[$slug]['quantity'] + $quantity;

            return $this->update($slug, $quantity);
        }

        if ($this->isStockAvailable($slug, $quantity)) {
            // TODO: Add translation
            return CartResponse::failed('The added quantity is higher then the available stock');
        }

        $this->cart[$slug] = ['quantity' => $quantity];

        return CartResponse::success('The item has been added');
    }

    /**
     * The items quantity can be updated.
     */
    public function update(string $slug, int $quantity): CartResponse
    {
        $item = $this->get()->firstWhere('slug', $slug);

        if (is_null($item)) {
            return CartResponse::failed('The given product could not be found');
        }

        if ($this->isStockAvailable($slug, $quantity)) {
            return CartResponse::failed('The updated quantity is higher then the available stock');
        }

        $this->cart[$slug]['quantity'] = $quantity;

        return CartResponse::success('The quantity has been updated');
    }

    /**
     * An item can be completly removed from the cart.
     */
    public function remove($slug): CartResponse
    {
        Arr::forget($this->cart, $slug);

        return CartResponse::success();
    }

    /**
     * Clear the complete cart.
     */
    public function clear(): CartResponse
    {
        $this->cart = [];

        return CartResponse::success();
    }

    /**
     * Fetch the customer from the session.
     */
    public function customer(): Customer|null
    {
        // TODO: Does this part belong here?

        return Session::get('butik.customer') !== null ?
            Session::get('butik.customer') :
            null;
    }

    /**
     * The total count of items.
     */
    public function count(): int
    {
        return $this->get()->map(function ($item) {
            return $item->quantity();
        })->sum();
    }

    public function totalPrice(): PriceRepository
    {
        $productAmount = $this->get()
            ->filter(fn ($item) => $item->isSellable())
            ->map(fn ($item) => $item->price()->total()->cents())
            ->sum();

//        $shippingAmount = $this->totalShipping();

        return Price::of($productAmount);
    }

    /**
     * All shipping costs, from all shipping profiles, summed
     * up to determine the total shipping costs.
     */
    public function totalShipping(): PriceRepository
    {
        $shippingAmount = $this->shipping()->sum(function ($shipping) {
            return Price::of($shipping->total)->cents();
        });

        return Price::of($shippingAmount);
    }

    /**
     * All taxes from products and shipping.
     */
    public function totalTaxes(): Collection
    {
        $taxes = collect();
        $taxRates = [];

        /**
         * Collect all item tax rates.
         */
        foreach ($this->get() as $item) {
            if (! in_array($item->tax()->rate(), $taxRates)) {
                $taxRates[] = $item->tax()->rate();
            }
        }

        /**
         * Collect all shipping tax rates.
         */
        // TODO: Add shipping taxes back to the cart
//        foreach ($this->shipping() as $shipping) {
//            if (! in_array($shipping->taxRate, $taxRates)) {
//                $taxRates[] = $shipping->taxRate;
//            }
//        }

        /**
         * We will loop through all tax rates and sum the amounts.
         */
        foreach ($taxRates as $taxRate) {
            $taxAmount = $this->get()
                ->filter(fn($item) =>  $item->tax()->rate() === $taxRate)
                ->sum(fn ($item) => $item->tax()->total()->cents());


//            // On top of that we need to add the tax amounts from our shipping rates
//            if ($shipping = $this->shipping()->firstWhere('taxRate', $taxRate)) {
//                $shippingAmount = Price::of($shipping->taxAmount)->cents();
//            }
//
//            $totalAmount = Price::of($itemAmount)->add($shippingAmount ?? 0)->get();

            // For better access in antlers views, the amount and rate will get converted to an array.
            // TODO: Create tax objects?
            $taxes->push([
                'amount' => Price::of($taxAmount)->get(),
                'rate'   => $taxRate,
            ]);
        }

        return $taxes;
    }

    /**
     * All shipping costs are seperated into the original
     * shipping profiles, where they came from.
     */
    public function shipping(): Collection
    {
        $shipping = new Shipping($this->cart);
        $shipping->handle();

        return $shipping->amounts;
    }

    /**
     * Getting the actual choosen country.
     */
    public function country(): string
    {
        // TODO: Should the country move to the Country Facade?
        return Country::iso();
    }

    /**
     * Set a different country to checkout to.
     */
    public function setCountry(string $isoCode): void
    {
        // TODO: Should the country move to the Country Facade?
        Country::set($isoCode);
    }

    public function removeNonSellableItems(): void
    {
        $this->cart = $this->get()->filter(function ($item) {
            return $item->sellable;
        });
    }

    /**
     * Is the product already saved in the cart?
     */
    public function contains(string $slug): bool
    {
        return Arr::exists($this->cart, $slug);
    }

    private function isStockAvailable($slug, $quantity): bool
    {
        return $quantity > Product::findBySlug($slug)->stock();
    }
}
