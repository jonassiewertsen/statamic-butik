@extends('statamic::layout')

@section('title', __('butik::product.create'))
@section('wrapper_class', 'max-w-3xl')

@section('content')
    <publish-form
        title="{{ __('butik::country.plural') }}"
        action="{{ cp_route('butik.countries.update', ['country' => $values['slug']]) }}"
        method="patch"
        :blueprint='@json($blueprint)'
        :meta='@json($meta)'
        :values='@json($values)'
    ></publish-form>
@stop
