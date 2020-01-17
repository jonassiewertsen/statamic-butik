@extends('statamic::layout')
@section('title', __('statamic-butik::taxes.navigation.create'))

@section('content')
    <publish-form
        title="{{ __('statamic-butik::tax.singular') }}"
        action="{{ cp_route('butik.taxes.store') }}"
        :blueprint='@json($blueprint)'
        :meta='@json($meta)'
        :values='@json($values)'
    ></publish-form>
@stop
