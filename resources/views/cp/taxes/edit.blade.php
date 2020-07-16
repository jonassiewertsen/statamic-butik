@extends('statamic::layout')

@section('title', ucfirst(__('butik::cp.tax_form_edit')))
@section('wrapper_class', 'max-w-3xl')

@section('content')
    <publish-form
        title="{{ ucfirst(__('butik::cp.tax_form_edit')) }}"
        action="{{ cp_route('butik.taxes.update', ['tax' => $slug]) }}"
        method="patch"
        :blueprint='@json($blueprint)'
        :meta='@json($meta)'
        :values='@json($values)'
    ></publish-form>
@stop
