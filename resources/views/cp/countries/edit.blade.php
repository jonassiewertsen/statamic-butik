@extends('statamic::layout')

@section('title', ucfirst(__('butik::cp.country_form_create')))
@section('wrapper_class', 'max-w-3xl')

@section('content')
    <publish-form
        title="{{ ucfirst(__('butik::cp.country_plural')) }}"
        action="{{ cp_route('butik.countries.update', ['country' => $values['slug']]) }}"
        method="patch"
        :blueprint='@json($blueprint)'
        :meta='@json($meta)'
        :values='@json($values)'
    ></publish-form>
@stop
