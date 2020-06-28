<?php

namespace Jonassiewertsen\StatamicButik\Blueprints;

use Jonassiewertsen\StatamicButik\Http\Models\ShippingProfile;
use Statamic\Facades\Blueprint as StatamicBlueprint;

class ShippingZoneBlueprint extends Blueprint
{
    private array $shippingTypeNames;

    public function __invoke()
    {
        return StatamicBlueprint::make()->setContents([
            'sections' => [
                'main' => [
                    'fields' => [
                        [
                            'handle' => 'title',
                            'field'  => [
                                'type'     => 'text',
                                'width'    => '50',
                                'display'  => __('butik::general.title'),
                                'validate' => 'required',
                            ],
                        ],
                        [
                            'handle' => 'type',
                            'field'  => [
                                'type'     => 'select',
                                'width'    => '50',
                                'options'  => $this->shippingTypes(),
                                'display'  => __('butik::shipping.type'),
                                'validate' => 'required',
                            ],
                        ],
                        [
                            'handle' => 'shipping_profile_slug',
                            'field'  => [
                                'type'     => 'hidden',
                                'validate' => 'required|exists:butik_shipping_profiles,slug',
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }

    /**
     * In case the Product will be edited, the slug will be read only
     */
    private function slugReadOnly(): bool
    {
        return $this->isRoute('statamic.cp.butik.shipping-zones.edit');
    }

    private function shippingzonesUniqueRule()
    {
        return $this->ignoreUnqiueOn(
            'butik_shipping_zones',
            'slug',
            'statamic.cp.butik.shipping-zones.update'
        );
    }

    private function fetchShippingProfiles(): array
    {
        return ShippingProfile::pluck('title', 'slug')->toArray();
    }

    private function shippingTypes(): array
    {
        $types                   = config('butik.shipping');
        $this->shippingTypeNames = [];

        foreach ($types as $slug => $shippingType) {
            $name = (new $shippingType())->name;

            $this->shippingTypeNames[$slug] = $name;
        }

        return $this->shippingTypeNames;
    }
}
