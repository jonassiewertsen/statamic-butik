@extends('statamic::layout')

@section('title', ucfirst(__('butik::cp.product_form_edit')))
@section('wrapper_class', 'max-w-3xl')

@section('content')
    <publish-form
        name="product edit stack"
        title="{{ ucfirst(__('butik::cp.product_form_edit')) }}"
        action="{{ cp_route('butik.products.update', ['product' => $productValues['slug']]) }}"
        method="patch"
        :blueprint='@json($productBlueprint)'
        :meta='@json($productMeta)'
        :values='@json($productValues)'
    ></publish-form>

    <butik-manage-product-variants
        action="{{ cp_route('butik.variants.store') }}"
        :variant-blueprint='@json($variantBlueprint)'
        :variant-meta='@json($variantMeta)'
        :variant-values='@json($variantValues)'
        :variant-index-route='@json($variantIndexRoute)'
        :variant-manage-route='@json($variantManageRoute)'
        :product-slug="'{{ $productValues['slug'] }}'"
    ></butik-manage-product-variants>

    <butik-manage-product-categories
        category-index-route="{{ cp_route('butik.categories.from-product', ['product' => $productValues['slug']]) }}"
        category-attach-route="{{ cp_route('butik.category.attach-product', ['category' => 'x-category', 'product' => 'x-product']) }}"
        category-manage-route="{{ cp_route('butik.categories.store') }}"
        :product-slug="'{{ $productValues['slug'] }}'"
    ></butik-manage-product-categories>
@stop
