@extends('statamic::layout')
@section('title', ucfirst(__('butik::cp.order_plural')))

@section('content')

    <div class="flex mb-3">
        <h1 class="flex-1">{{ ucfirst(__('butik::cp.order_plural')) }}</h1>
    </div>

    @unless($orders->isEmpty())

        <butik-order-list
            :initial-rows="{{ json_encode($orders) }}"
            :columns="{{ json_encode($columns) }}"
            :endpoints="{}">
        ></butik-order-list>

    @else

        <div class="card">
            {{ __('butik::cp.order_description') }}
        </div>

    @endunless

@endsection
