@extends('statamic::layout')

@section('title', __('butik::shipping.create'))
@section('wrapper_class', 'max-w-3xl')

@section('content')
    <publish-form
        title="{{ __('butik::shipping.singular') }}"
        action="{{ cp_route('butik.shippings.store') }}"
        :blueprint='@json($blueprint)'
        :meta='@json($meta)'
        :values='@json($values)'
    ></publish-form>
@stop
