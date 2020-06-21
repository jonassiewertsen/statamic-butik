<?php


namespace Jonassiewertsen\StatamicButik\Shipping;

use Illuminate\Support\Collection;
use Jonassiewertsen\StatamicButik\Exceptions\ButikConfigException;
use Jonassiewertsen\StatamicButik\Exceptions\ButikShippingException;
use Jonassiewertsen\StatamicButik\Http\Models\Country;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingProfile;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingZone;
use Jonassiewertsen\StatamicButik\Http\Traits\MoneyTrait;
use phpDocumentor\Reflection\Types\Mixed_;

class Shipping
{
    use MoneyTrait;

    /**
     * Will save the total shipping amounts
     */
    public Collection $amounts;

    /**
     * Which country should we ship to?
     */
    public Country $country;

    /**
     * Which shipping profiles are used in the acutal shopping bag?
     */
    public Collection $profiles;

    /**
     * The cart including all items in the shopping cart
     */
    public Collection $items;

    public function __construct(Collection $cart)
    {
        $this->items    = $cart;
        $this->amounts  = collect();
        $this->profiles = collect();
    }

    public function handle(): void
    {
        $this->detectCountry();
        $this->detectUsedShippingProfiles();

        // TODO: Does a shipping zone exist for the selected country ?

        foreach ($this->profiles as $profile) {
            // detect zone
            $zone = $this->detectShippingZone($profile);

            if ($zone === null) {
                // TODO: Add message to item if not buyable because of the shipping
                break;
            }

            $items = $this->filterItems($profile);

            $shippingStrategy = $this->getShippingStrategy($zone);

            $shippingType = new $shippingStrategy($items, $zone);
            $shippingType->set($items, $zone);

            $this->amounts->push(
                $shippingType->calculate(),
            );
        }
    }

    /**
     * Which country is selected. It will choose the given country
     * default to the country defined in the config file.
     *
     * @throws ButikConfigException
     */
    protected function detectCountry()
    {
        $countryFromConfig = config('butik.country');

        $country = Country::where('name', 'LIKE', '%' . $countryFromConfig . '%')->first();

        if ($country === null) {
            throw new ButikConfigException('Your defined Country inside your config file does not exist.');
        }

        $this->country = $country;
    }

    /**
     * Detect and collect profiles, used by the items in the shopping bag.
     */
    protected function detectUsedShippingProfiles(): void
    {
        $this->items->each(function ($item) {
            if (!$this->profiles->contains($item->shippingProfile)) {
                $this->profiles->push($item->shippingProfile);
            }
        });
    }

    /**
     * The detected shipping zone, belonging to our selected country.
     */
    protected function detectShippingZone($profile): ?ShippingZone
    {
        return $profile->whereZoneFrom($this->country);
    }

    /**
     * Filter items, so that only items belonging to the selected shipping
     * profile will be used to calculate the shipping costs.
     */
    private function filterItems(ShippingProfile $profile): Collection
    {
        return $this->items->filter(function ($item) use ($profile) {
            return $item->shippingProfile->slug === $profile->slug;
        });
    }

    /**
     * We will get the shipiping strategy as defined in the butik config file.
     *
     * @throws ButikShippingException
     */
    private function getShippingStrategy($zone): string
    {
        $shippingStrategies = config('butik.shipping');

        if (!key_exists($zone->type, $shippingStrategies)) {
            throw new ButikShippingException('We could not find the "' . $zone->type . '" shipping class as defined in your butik config file.');
        }

        return $shippingStrategies[$zone->type];
    }
}
