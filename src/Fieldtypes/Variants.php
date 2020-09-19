<?php

namespace Jonassiewertsen\StatamicButik\Fieldtypes;

use Jonassiewertsen\StatamicButik\Blueprints\VariantBlueprint;
use Statamic\Fields\Fieldtype;

class Variants extends Fieldtype
{
    protected $categories = ['butik'];
    protected $icon       = 'tags';

    public function preload()
    {
        $product          = $this->field()->parent();
        $variantBlueprint = new VariantBlueprint();
        $variantFields    = $variantBlueprint()->fields()->addValues([])->preProcess();

        return [
            'action'             => cp_route('butik.variants.store'),
            'variantIndexRoute'  => cp_route('butik.variants.from-product', $product->slug()),
            'variantManageRoute' => cp_route('butik.variants.store'),
            'variantBlueprint'   => $variantBlueprint()->toPublishArray(),
            'variantValues'      => $variantFields->values(),
            'variantMeta'        => $variantFields->meta(),
            'productSlug'        => $product->slug(),
        ];
    }

    public function process($data)
    {
        return $data;
    }

    public function preProcess($data)
    {
        return $data;
    }
}
