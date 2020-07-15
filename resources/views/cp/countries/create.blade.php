@extends('statamic::layout')

@section('title', ucfirst(__('butik::cp.country_form_edit')))
@section('wrapper_class', 'max-w-3xl')

@section('content')
    <publish-form
        title="{{ __('butik::cp.country_form_edit') }}"
        action="{{ cp_route('butik.countries.store') }}"
        :blueprint='@json($blueprint)'
        :meta='@json($meta)'
        :values='@json($values)'
    ></publish-form>
@stop
