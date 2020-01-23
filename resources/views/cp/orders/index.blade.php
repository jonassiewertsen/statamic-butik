@extends('statamic::layout')
@section('title', __('statamic-butik::product.navigation.index'))

@section('content')

    @unless($orders->isEmpty())

        <div class="flex mb-3">
            <h1 class="flex-1">{{ __('statamic-butik::order.name.plural') }}</h1>
        </div>

        <butik-order-list
            :initial-rows="{{ json_encode($orders) }}"
            :columns="{{ json_encode($columns) }}"
            :endpoints="{}">
        ></butik-order-list>

    @else

        @include('statamic::partials.create-first', [
            'resource' => __('statamic-butik::order.name.singular'),
            'description' => __('statamic-butik::order.description'),
            'svg' => 'empty/collection',
            'route' => cp_route('butik.orders.create'),
            // TODO: I should set permissions right here
             'can' => auth()->user()->can('create', 'Statamic\Contracts\Entries\Collection')
        ])

    @endunless

@endsection
