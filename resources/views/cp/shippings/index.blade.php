@extends('statamic::layout')
@section('title', __('statamic-butik::shipping.navigation.index'))

@section('content')

    @unless($shippings->isEmpty())

        <div class="flex mb-3">
            <h1 class="flex-1">{{ __('statamic-butik::shipping.plural') }}</h1>
                {{-- TODO: add permissions --}}
{{--            @can('create', 'Statamic\Contracts\Entries\Collection')--}}
                <a href="{{ cp_route('butik.shippings.create') }}" class="btn-primary">{{ __('statamic-butik::shipping.navigation.create') }}</a>
{{--            @endcan--}}
        </div>

        <butik-shipping-list
            :initial-rows="{{ json_encode($shippings) }}"
            :columns="{{ json_encode($columns) }}"
            :endpoints="{}">
        ></butik-shipping-list>

    @else

        @include('statamic::partials.create-first', [
            'resource' => __('statamic-butik::shipping.singular'),
            'description' => __('statamic-butik::shipping.description'),
            'svg' => 'empty/collection',
            'route' => cp_route('butik.shippings.create'),
            // TODO: I should set permissions right here
             'can' => auth()->user()->can('create', 'Statamic\Contracts\Entries\Collection')
        ])

    @endunless

@endsection
