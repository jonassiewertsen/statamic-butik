@extends('butik::web.layouts.shop')

@section('content')

    <div class="b-block md:b-flex">
        {{-- Images --}}
        @if (! empty($product->images))
            <img class="b-w-full md:b-w-1/2" src="/assets/{{ $product->images->first() }}">
        @else
            <div class="b-w-full md:b-w-1/2">
                @include('butik::web.shop.partials.placeholder')
            </div>
        @endif

        <div class="b-px-5 md:b-w-1/2 b-w-full">


            @if ($product->stock_unlimited || $product->stock  > 0)
                <h1 class="b-mt-2 b-text-2xl">{{ $product->title }}</h1>
            @else
                <h1 class="b-mt-2 b-text-2xl">
                    <s>{{ $product->title }}</s>
                    <span class="b-text-sm b-ml-2">{{ __('butik::product.sold_out') }}</span>
                </h1>
            @endif

            <div class="b-text-gray-500 b-text-sm b-mt-2">{{ $product->base_price }} {{ $product->currency }} {{ __('butik::product.base_price') }}</div>
            <div class="b-text-gray-500 b-text-sm">{{ $product->shipping_amount }} {{ $product->currency }} {{ __('butik::general.shipping') }}</div>
            <div class="b-text-gray-700 b-text-3xl b-mt-2">{{ $product->total_price }} {{ $product->currency }} {{ __('butik::product.total') }}</div>

            @if ($product->stock_unlimited || $product->stock  > 0)
                <a class="b-bg-gray-900 b-block b-mt-5 b-py-2 b-rounded b-text-center b-text-white b-text-xl hover:b-bg-gray-800"
                   href="{{ $product->express_delivery_url }}"
                >
                    {{ __('butik::payment.express_checkout') }}
                </a>
            @endif

            @if ($product->description )
                <p class="b-mt-8">{{ $product->description }}</p>
            @endif

            <a class="lg:b-hidden b--mb-3 b-block b-flex b-mt-8 b-text-gray-400 hover:b-text-gray-500" href="{{ route('butik.shop') }}">
                <svg class="b-fill-current b-mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path class="heroicon-ui" d="M5.41 11H21a1 1 0 0 1 0 2H5.41l5.3 5.3a1 1 0 0 1-1.42 1.4l-7-7a1 1 0 0 1 0-1.4l7-7a1 1 0 0 1 1.42 1.4L5.4 11z"/></svg>
                <span>{{ __('butik::general.back') }}</span>
            </a>
        </div>
    </div>

@endsection
