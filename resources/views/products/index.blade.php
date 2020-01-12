@extends('statamic::layout')
@section('title', __('statamic-butik::product.navigation.index'))

@section('content')

    @unless($products->isEmpty())

        <div class="flex mb-3">
            <h1 class="flex-1">{{ __('statamic-butik::product.name.plural') }}</h1>
                {{-- TODO: add permissions --}}
{{--            @can('create', 'Statamic\Contracts\Entries\Collection')--}}
                <a href="{{ cp_route('butik.products.create') }}" class="btn-primary">{{ __('statamic-butik::product.navigation.create') }}</a>
{{--            @endcan--}}
        </div>

        <butik-product-list
            :initial-rows="{{ json_encode($products) }}"
            :columns="{{ json_encode($columns) }}"
            :endpoints="{}">
        ></butik-product-list>

{{--                <statamic-product-list--}}
{{--                    :initial-rows="{{ json_encode($products) }}"--}}
{{--                    :columns="{{ json_encode($columns) }}"--}}
{{--                    :endpoints="{}">--}}
{{--                </statamic-product-list>--}}

{{--        <collection-list--}}
{{--            :initial-rows="{{ json_encode($products) }}"--}}
{{--            :columns="{{ json_encode($columns) }}"--}}
{{--            :endpoints="{}">--}}
{{--        </collection-list>--}}

    @else

        @include('statamic::partials.create-first', [
            'resource' => __('statamic-butik::product.name.singular'),
            'description' => __('statamic-butik::product.description'),
            'svg' => 'empty/collection',
            'route' => cp_route('butik.product.create'),
            // TODO: I should set permissions right here
             'can' => auth()->user()->can('create', 'Statamic\Contracts\Entries\Collection')
        ])

    @endunless

@endsection
