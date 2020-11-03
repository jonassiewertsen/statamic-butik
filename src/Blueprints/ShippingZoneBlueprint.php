<?php

namespace Jonassiewertsen\StatamicButik\Blueprints;

use Jonassiewertsen\StatamicButik\Http\Models\ShippingZone;
use Jonassiewertsen\StatamicButik\Http\Models\Tax;
use Statamic\Facades\Blueprint as StatamicBlueprint;
use Symfony\Component\Intl\Countries;

class ShippingZoneBlueprint extends Blueprint
{
    // TODO: Refactor this blueprint
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
                                'width'    => '100',
                                'display'  => __('butik::cp.name'),
                                'validate' => 'required',
                            ],
                        ],
                        [
                            'handle' => 'type',
                            'field'  => [
                                'type'     => 'select',
                                'width'    => '50',
                                'default'  => 'price',
                                'options'  => $this->shippingTypes(),
                                'display'  => __('butik::cp.type'),
                                'validate' => 'required',
                            ],
                        ],
                        [
                            'handle' => 'tax_slug',
                            'field'  => [
                                'type'     => 'select',
                                'width'    => '50',
                                'default'  => __('butik::cp.tax_none'),
                                'options'  => $this->fetchTaxOptions(),
                                'display'  => __('butik::cp.tax_plural'),
                                'validate' => 'nullable',
                            ],
                        ],
                        [
                            'handle' => 'shipping_profile_slug',
                            'field'  => [
                                'type'     => 'hidden',
                                'validate' => 'required|exists:butik_shipping_profiles,slug',
                            ],
                        ],
                        [
                            'handle' => 'countries',
                            'field' => [
                                'type' => 'select',
                                'options' => Countries::getNames(app()->getLocale()),
                                'clearable' => false,
                                'multiple' => true,
                                'searchable' => true,
                                'taggable' => false,
                                'push_tags' => false,
                                'cast_booleans' => false,
                                'localizable' => false,
                                'listable' => true,
                                'display' => 'Countries',
                                'validate' => ['required', 'array',
                                    function ($attribute, $value, $fail) {
                                        foreach ($value as $country_code) {
                                            if (! Countries::exists($country_code)) {
                                                $fail('Invalid country code: ' . $country_code);
                                            }
                                        }
                                    },
                                    function ($attribute, $value, $fail) {
                                        if(ShippingZone::all()
                                            ->filter(function($shippingZone) use ($value) {
                                                foreach ($value as $country_code) {
                                                    if ($shippingZone->countries && $shippingZone->countries->contains($country_code)) {
                                                        return true;
                                                    }
                                                }
                                            })
                                            ->count() > 1) {
                                            $fail('One of the countries is already added to another shipping zone.');
                                        }
                                    }
                                ]
                            ]
                        ]
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

    private function fetchTaxOptions(): array {
        $taxes =  Tax::pluck('title', 'slug')->toArray();
        // Prepending a no tax option
        return ['' => __('butik::cp.tax_none')] + $taxes;
    }

    private function shippingTypes(): array
    {
        $types             = config('butik.shipping');
        $shippingTypeNames = [];

        foreach ($types as $slug => $shippingType) {
            $name = (new $shippingType())->name;

            $shippingTypeNames[$slug] = $name;
        }

        return $shippingTypeNames;
    }
}
