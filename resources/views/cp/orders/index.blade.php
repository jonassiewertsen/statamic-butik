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

       No Orders yet

    @endunless

@endsection
