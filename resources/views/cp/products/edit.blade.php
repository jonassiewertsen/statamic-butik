@extends('statamic::layout')

@section('title', __('butik::product.create'))
@section('wrapper_class', 'max-w-3xl')

@section('content')
    <publish-form
        title="{{ __('butik::product.form_title') }}"
        action="{{ cp_route('butik.products.update', ['product' => $values['slug']]) }}"
        method="patch"
        :blueprint='@json($blueprint)'
        :meta='@json($meta)'
        :values='@json($values)'
    ></publish-form>

    <butik-manage-product-categories
        :categories='@json($categories)'
        route="{{ cp_route('butik.category.attach-product', ['category' => 'x-category', 'product' => 'x-product']) }}"
        :product-slug="'{{ $values['slug'] }}'"
    ></butik-manage-product-categories>
@stop
