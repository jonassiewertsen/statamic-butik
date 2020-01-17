@extends('statamic::layout')
@section('title', __('statamic-butik::shippings.navigation.create'))

@section('content')
    <publish-form
        title="{{ __('statamic-butik::shipping.singular') }}"
        action="{{ cp_route('butik.shippings.store') }}"
        :blueprint='@json($blueprint)'
        :meta='@json($meta)'
        :values='@json($values)'
    ></publish-form>
@stop
