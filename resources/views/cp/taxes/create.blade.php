@extends('statamic::layout')
@section('title', __('butik::tax.create'))

@section('content')
    <publish-form
        title="{{ __('butik::tax.singular') }}"
        action="{{ cp_route('butik.taxes.store') }}"
        :blueprint='@json($blueprint)'
        :meta='@json($meta)'
        :values='@json($values)'
    ></publish-form>
@stop
