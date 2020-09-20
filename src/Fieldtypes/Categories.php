<?php

namespace Jonassiewertsen\StatamicButik\Fieldtypes;

use Jonassiewertsen\StatamicButik\Blueprints\VariantBlueprint;
use Statamic\Fields\Fieldtype;

class Categories extends Fieldtype
{
    protected $categories = ['butik'];
    protected $icon       = 'tags';

    public function preload()
    {
        $product = $this->field()->parent();

        return [
            'categoryIndexRoute'  => cp_route('butik.categories.from-product', ['product' => $product->slug() ]),
            'categoryAttachRoute' => cp_route('butik.category.attach-product', ['category' => 'x-category', 'product' => 'x-product']),
            'categoryManageRoute' => cp_route('butik.categories.store'),
            'productSlug'         => $product->slug(),
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
