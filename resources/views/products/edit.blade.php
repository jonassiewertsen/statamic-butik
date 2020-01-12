@extends('statamic::layout')
@section('title', __('statamic-butik::product.navigation.create'))

@section('content')
    <publish-form
        title="{{ __('statamic-butik::product.form.form_title') }}"
        action="{{ cp_route('butik.products.update', ['product' => $values['slug']]) }}"
        :blueprint='@json($blueprint)'
        :meta='@json($meta)'
        :values='@json($values)'
    ></publish-form>
@stop
