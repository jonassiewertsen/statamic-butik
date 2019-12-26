@extends('statamic::layout')
@section('title', __('statamic-butik::product.navigation.create'))

@section('content')
    <publish-form
        title="{{ __('statamic-butik::product.form.form_title') }}"
        action="{{ cp_route('butik.product.store') }}"
        :blueprint='@json($blueprint)'
        :meta='@json($meta)'
        :values='@json($values)'
    ></publish-form>
@stop
