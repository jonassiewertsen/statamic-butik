<?php

namespace Jonassiewertsen\Butik\Shipping;

use Illuminate\Support\Collection;
use Jonassiewertsen\Butik\Cart\CartItemCollection;
use Jonassiewertsen\Butik\Contracts\CartRepository;
use Jonassiewertsen\Butik\Contracts\CountryRepository;
use Jonassiewertsen\Butik\Contracts\ShippingRepository;
use Jonassiewertsen\Butik\Exceptions\ButikConfigException;
use Jonassiewertsen\Butik\Exceptions\ButikShippingException;

class Shipping implements ShippingRepository
{
    /**
     * Will save the total shipping amounts.
     */
    public Collection $amounts;

    /**
     * Which country should we ship to?
     */
//    public string $country;

    /**
     * Which shipping profiles are used in the acutal shopping bag?
     */
//    public Collection $profiles;

    /**
     * The cart including all items in the shopping cart.
     */
    public CartItemCollection $items;

    public function __construct(CountryRepository $country, CartRepository $cart)
    {
        $this->items = $cart->get();
        $this->amounts = collect();
//        $this->profiles = collect();
    }

    public function calculate()
    {
        // TODO: Implement calculate() method.
    }

    public function country(): CountryRepository
    {
        // TODO: Implement country() method.
    }

    public function handle(): void
    {
//        $this->detectCountry();
//        $this->detectUsedShippingProfiles();
//
//        foreach ($this->profiles as $profile) {
//            throw_unless($profile, new ButikShippingException('One of your products contains a relationship to a non existing shipping profile. Please check your products and assign all of them a existing shipping profile.'));
//
//            $zone = $this->detectShippingZone($profile);
//            $items = $this->filterItems($profile);
//
//            // In case no zone could be detected, we will set the items to non sellable.
//            // This happens, if the items are not available in the choosen country.
//            if ($zone === null) {
//                $items->each->nonSellable();
//                break;
//            } else {
//                $items->each->sellable();
//            }
//
//            $shippingStrategy = $this->getShippingStrategy($zone);
//
//            $shippingType = new $shippingStrategy($items, $zone);
//            $shippingType->set($items, $zone);
//
//            $this->addShippingAmount($shippingType);
//        }
    }

    /**
     * Detect and collect profiles, used by the items in the shopping bag.
     */
    protected function detectUsedShippingProfiles(): void
    {
//        $this->items->each(function ($item) {
//            if (! $this->profiles->contains('slug', $item->shippingProfile->slug)) {
//                $this->profiles->push($item->shippingProfile);
//            }
//        });
    }

    /**
     * The detected shipping zone, belonging to our selected country.
     */
    protected function detectShippingZone(ShippingProfile $profile): ?ShippingZone
    {
//        return $profile->whereZoneFrom($this->country);
    }

    /**
     * Filter items, so that only items belonging to the selected shipping
     * profile will be used to calculate the shipping costs.
     */
    private function filterItems(ShippingProfile $profile): Collection
    {
//        return $this->items->filter(function ($item) use ($profile) {
//            return $item->shippingProfile->slug === $profile->slug;
//        });
    }

    /**
     * We will get the shipiping strategy as defined in the butik config file.
     *
     * @throws ButikShippingException
     */
    private function getShippingStrategy($zone): string
    {
//        $shippingStrategies = config('butik.shipping');
//
//        if (! key_exists($zone->type, $shippingStrategies)) {
//            throw new ButikShippingException('We could not find the "'.$zone->type.'" shipping class as defined in your butik config file.');
//        }
//
//        return $shippingStrategies[$zone->type];
    }

    /**
     * Adds the shipping amount to the class.
     */
    private function addShippingAmount($shippingType): void
    {
//        $this->amounts->push(
//            $shippingType->calculate(),
//        );
    }
}
