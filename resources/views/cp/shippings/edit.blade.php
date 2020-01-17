@extends('statamic::layout')
@section('title', __('statamic-butik::tax.navigation.create'))

@section('content')
    <publish-form
        title="{{ __('statamic-butik::cp.title') }}"
        action="{{ cp_route('butik.taxes.update', ['tax' => $id]) }}"
        method="patch"
        :blueprint='@json($blueprint)'
        :meta='@json($meta)'
        :values='@json($values)'
    ></publish-form>
@stop
