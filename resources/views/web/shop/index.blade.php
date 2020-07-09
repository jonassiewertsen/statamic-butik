@extends('butik::web.layouts.shop')

@section('content')

    <div class="b-px-6">
        <div class="b-flex b-flex-wrap b--mx-12">

            @foreach($products as $product)
                <div class="b-block b-px-12 b-mb-10 b-w-1/2 md:b-w-1/3">
                    <a href="{{ $product->show_url }}" class="b-block b-w-full">

                        @if (! empty($product->images))
                            <img class="b-w-full b-rounded-xl b-h-64 b-object-cover b-transform b-duration-700 hover:b-shadow-2xl hover:b--translate-y-2" src="/assets/{{ $product->images[0] }}">
                        @else
                            <div class="b-w-full">
                                @include('butik::web.shop.partials.placeholder')
                            </div>
                        @endif

                        <h1 class="b-mt-4 b-text-2xl b-text-center b-leading-none">{{ $product->title }}</h1>

                        @unless ($product->stock_unlimited || $product->stock  > 0)
                            <p class="b-text-sm b-block b-text-center b-ml-2">{{ __('butik::product.sold_out') }}</p>
                        @else
                            <div class="b-text-gray-500 b-text-xl b-text-center">{{ currency() }} {{ $product->price }}</div>
                        @endunless
                    </a>
                </div>
            @endforeach
        </div>
    </div>


@endsection
