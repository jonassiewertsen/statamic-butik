<?php

namespace Jonassiewertsen\StatamicButik\Fieldtypes;

use Jonassiewertsen\StatamicButik\Blueprints\CategoryBlueprint;
use Jonassiewertsen\StatamicButik\Http\Traits\FieldsetHelper;
use Statamic\Fields\Fieldtype;

class Categories extends Fieldtype
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
        $categoryBlueprint = new CategoryBlueprint();
        $categoryFields = $categoryBlueprint()->fields()->addValues([])->preProcess();

        return [
            'categoryIndexRoute'  => cp_route('butik.categories.from-product', ['product' => $product->slug()]),
            'categoryAttachRoute' => cp_route('butik.category.attach-product', ['category' => 'x-category', 'product' => 'x-product']),
            'categoryManageRoute' => cp_route('butik.categories.store'),
            'categoryBlueprint'   => $categoryBlueprint()->toPublishArray(),
            'categoryValues'      => $categoryFields->values(),
            'categoryMeta'        => $categoryFields->meta(),
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
