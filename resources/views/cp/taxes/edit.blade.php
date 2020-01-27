@extends('statamic::layout')
@section('title', __('butik::tax.create'))

@section('content')
    <publish-form
        title="{{ __('butik::general.title') }}"
        action="{{ cp_route('butik.taxes.update', ['tax' => $slug]) }}"
        method="patch"
        :blueprint='@json($blueprint)'
        :meta='@json($meta)'
        :values='@json($values)'
    ></publish-form>
@stop
