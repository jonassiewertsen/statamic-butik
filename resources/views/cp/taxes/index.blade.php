@extends('statamic::layout')
@section('title', __('statamic-butik::tax.navigation.index'))

@section('content')

    @unless($taxes->isEmpty())

        <div class="flex mb-3">
            <h1 class="flex-1">{{ __('statamic-butik::tax.plural') }}</h1>
            @can('create', 'Jonassiewertsen\StatamicButik\Http\Models\Product\Tax')
                <a href="{{ cp_route('butik.taxes.create') }}" class="btn-primary">{{ __('statamic-butik::tax.navigation.create') }}</a>
            @endcan
        </div>

        <butik-tax-list
            :initial-rows="{{ json_encode($taxes) }}"
            :columns="{{ json_encode($columns) }}"
            :endpoints="{}">
        ></butik-tax-list>

    @else

        @include('statamic::partials.create-first', [
            'resource' => __('statamic-butik::tax.singular'),
            'description' => __('statamic-butik::tax.description'),
            'svg' => 'empty/collection',
            'route' => cp_route('butik.taxes.create'),
             'can' => auth()->user()->can('create', 'Jonassiewertsen\StatamicButik\Http\Models\Product\Tax')
        ])

    @endunless

@endsection
