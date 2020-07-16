@extends('statamic::layout')

@section('title', ucfirst(__('butik::cp.product_form_create')))
@section('wrapper_class', 'max-w-3xl')

@section('content')
    <publish-form-redirect
        title="{{ ucfirst(__('butik::cp.product_form_create')) }}"
        action="{{ cp_route('butik.products.store') }}"
        :blueprint='@json($blueprint)'
        :meta='@json($meta)'
        :values='@json($values)'
        redirect-to="{{ cp_route('butik.products.edit', ['product' => 'x-product']) }}"
    ></publish-form-redirect>
@stop
