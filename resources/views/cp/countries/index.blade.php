@extends('statamic::layout')
@section('title', ucfirst(__('butik::cp.country_plural')))

@section('content')

    @unless($countries->isEmpty())

        <div class="flex mb-3">
            <h1 class="flex-1">{{ __('butik::cp.country_plural') }}</h1>
            @can('create', 'Jonassiewertsen\StatamicButik\Http\Models\Country')
                <a href="{{ cp_route('butik.countries.create') }}" class="btn-primary">{{ __('butik::cp.country_form_create') }}</a>
            @endcan
        </div>

        <butik-country-list
            :initial-rows="{{ json_encode($countries) }}"
            :columns="{{ json_encode($columns) }}"
            :endpoints="{}">
        ></butik-country-list>

    @else

        @include('statamic::partials.create-first', [
            'resource' => __('butik::cp.country_singular'),
            'description' => __('butik::cp.country_description'),
            'svg' => 'empty/collection',
            'route' => cp_route('butik.countries.create'),
             'can' => auth()->user()->can('create', 'Jonassiewertsen\StatamicButik\Http\Models\Country')
        ])

    @endunless

@endsection
