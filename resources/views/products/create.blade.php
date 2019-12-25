@extends('statamic::layout')

@section('content')
    <publish-form
        title="{{ __('statamic-butik::product.form.creating.form_title') }}"
        action="{{ cp_route('butik.product.store') }}"
        :blueprint='@json($blueprint)'
        :meta='@json($meta)'
        :values='@json($values)'
    ></publish-form>
@stop
