@extends('statamic::layout')

@section('title', ucfirst(__('butik::cp.tax_form_create')))
@section('wrapper_class', 'max-w-3xl')

@section('content')
    <publish-form
        title="{{ __('butik::cp.tax_singular') }}"
        action="{{ cp_route('butik.taxes.store') }}"
        :blueprint='@json($blueprint)'
        :meta='@json($meta)'
        :values='@json($values)'
    ></publish-form>
@stop
