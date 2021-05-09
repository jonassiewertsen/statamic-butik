<?php

namespace Jonassiewertsen\Butik\Fieldtypes;

use Jonassiewertsen\Butik\Blueprints\VariantBlueprint;
use Jonassiewertsen\Butik\Support\Traits\FieldsetHelper;
use Statamic\Fields\Fieldtype;

class Variants extends Fieldtype
{
    use FieldsetHelper;

    protected $categories = ['butik'];
    protected $icon = 'tags';

    public function preload()
    {
        if ($this->isCreateRoute()) {
            return ['isCreateRoute' => true];
        }

        $product = $this->field()->parent();
        $variantBlueprint = new VariantBlueprint();
        $variantFields = $variantBlueprint()->fields()->addValues([])->preProcess();

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
