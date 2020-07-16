@extends('statamic::layout')
@section('title', ucfirst(__('butik::cp.product_plural')))

@section('content')

    @unless($products->isEmpty())

        <div class="flex mb-3">
            <h1 class="flex-1">{{ ucfirst(__('butik::cp.product_plural')) }}</h1>

            @can('create', 'Jonassiewertsen\StatamicButik\Http\Models\Product')
                <a href="{{ cp_route('butik.products.create') }}" class="btn-primary">{{ __('butik::cp.product_form_create') }}</a>
            @endcan
        </div>

        <butik-product-list
            :initial-rows="{{ json_encode($products) }}"
            :columns="{{ json_encode($columns) }}"
            :endpoints="{}">
        ></butik-product-list>

    @else

        @include('statamic::partials.create-first', [
            'resource' => __('butik::cp.product_singular'),
            'description' => __('butik::cp.product_form_create'),
            'svg' => 'empty/collection',
            'route' => cp_route('butik.products.create'),
             'can' => auth()->user()->can('create', 'Jonassiewertsen\StatamicButik\Http\Models\Product')
        ])

    @endunless

@endsection
