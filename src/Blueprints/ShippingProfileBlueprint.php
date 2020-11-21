<?php

namespace Jonassiewertsen\StatamicButik\Blueprints;

use Statamic\Facades\Blueprint as StatamicBlueprint;

class ShippingProfileBlueprint extends Blueprint
{
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
                                'display'  => __('butik::cp.name'),
                                'validate' => 'required',
                            ],
                        ],
                        [
                            'handle' => 'slug',
                            'field'  => [
                                'type'      => 'slug',
                                'display'   => __('butik::cp.slug'),
                                'validate'  => ['required', $this->shippingprofileUniqueRule()],
                                'read_only' => $this->slugReadOnly(),
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }

    /**
     * In case the Product will be edited, the slug will be read only.
     */
    private function slugReadOnly(): bool
    {
        return $this->isRoute('statamic.cp.butik.shipping-types.edit');
    }

    private function shippingprofileUniqueRule()
    {
        return $this->ignoreUnqiueOn(
            'butik_shipping_profiles',
            'slug',
            'statamic.cp.butik.shipping-profiles.update'
        );
    }
}
