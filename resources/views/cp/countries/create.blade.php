@extends('statamic::layout')

@section('title', __('butik::country.create'))
@section('wrapper_class', 'max-w-3xl')

@section('content')
    <publish-form
        title="{{ __('butik::country.form_title') }}"
        action="{{ cp_route('butik.countries.store') }}"
        :blueprint='@json($blueprint)'
        :meta='@json($meta)'
        :values='@json($values)'
    ></publish-form>
@stop
