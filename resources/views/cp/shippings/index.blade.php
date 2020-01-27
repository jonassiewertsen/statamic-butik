@extends('statamic::layout')
@section('title', __('butik::shipping.index'))

@section('content')

    @unless($shippings->isEmpty())

        <div class="flex mb-3">
            <h1 class="flex-1">{{ __('butik::shipping.plural') }}</h1>
            @can('create', 'Jonassiewertsen\StatamicButik\Http\Models\Product\Shipping')
                <a href="{{ cp_route('butik.shippings.create') }}" class="btn-primary">{{ __('butik::shipping.create') }}</a>
            @endcan
        </div>

        <butik-shipping-list
            :initial-rows="{{ json_encode($shippings) }}"
            :columns="{{ json_encode($columns) }}"
            :endpoints="{}">
        ></butik-shipping-list>

    @else

        @include('statamic::partials.create-first', [
            'resource' => __('butik::shipping.singular'),
            'description' => __('butik::shipping.description'),
            'svg' => 'empty/collection',
            'route' => cp_route('butik.shippings.create'),
             'can' => auth()->user()->can('create', 'Jonassiewertsen\StatamicButik\Http\Models\Product\Shipping')
        ])

    @endunless

@endsection
