@extends('statamic::layout')
@section('title', __('butik::cp.order_overview'))
@section('wrapper_class', 'max-w-full')

@section('content')

    <div class="flex mb-3">
        <h1 class="flex-1">{{ __('butik::cp.order_overview') }}</h1>
    </div>

    <butik-order-list
{{--            run-action-url="{{ cp_route('akismet.actions.run', $form->handle()) }}"--}}
{{--            bulk-actions-url="{{ cp_route('akismet.actions.bulk', $form->handle()) }}"--}}
        initial-sort-column="date"
        initial-sort-direction="desc"
        v-cloak
    ></butik-order-list>

@endsection
