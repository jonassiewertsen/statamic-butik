@extends('butik::web.layouts.express-checkout')

@section('content')

    @include('butik::web.checkout.partials.status', ['delivery' => true])

    <hr class="b-mb-5 b-mt-8">

    <h1 class="b-block b-mb-10 md:b-mb-20 b-text-center b-font-bold b-text-xl">
        {{ __('butik::checkout.name') }}
    </h1>

    {{-- body --}}
    <div class="b-mt-6 b-mb-20 md:b-flex">

        {{-- delivery form --}}
        @include('butik::web.checkout.partials.delivery-form')

        {{-- product card --}}
        <div class="b-bg-gray-200 b-px-10 b-py-8 b-w-full lg:b-w-1/2">
            @foreach ($items as $item)
                <section class="b-flex b-mt-3f">
                    <figure class="b-w-1/5 b-mr-5">
                        @if (! empty($item->images))
                            <img src="/assets/{{ $item->images[0] }}">
                        @else
                            <div class="b-w-full">
                                @include('butik::web.shop.partials.placeholder')
                            </div>
                        @endif
                    </figure>

                    <div class="b-w-full">
                        <h3 class="b-font-bold">{{ $item->name }}</h3>
                        <p>{{ $item->description }}</p>
                        <div class="b-flex b-justify-end b-items-baseline">
                            <span class="b-mr-5 b-text-sm b-italic">{{ currency() }} {{ $item->singlePrice() }} x {{ $item->getQuantity() }}</span>
                            <span class="b-font-bold">{{ currency() }} {{ $item->totalPrice() }}</span>
                        </div>
                    </div>
                </section>
            @endforeach

                <section class="b-w-full b-mt-4">

                    <h3 class="b-font-bold b-block b-mt-5 b-text-3xl b-text-center">Total</h3>

                    <hr class="b-border-white b-my-5">

                    <div class="b-flex b-my-3 b-justify-between b-max-w-sm b-mx-auto">
                        <span>{{ __('butik::payment.shipping') }}</span>
                        <span>{{ currency() }} {{ $total_shipping }}</span>
                    </div>

                    <hr class="b-border-white b-my-5">

                    <div class="b-flex b-mt-3 b-justify-between b-max-w-sm b-mx-auto">
                        <span>{{ __('butik::payment.total') }}</span>
                        <span class="b-font-black">{{ currency() }} {{ $total_price }}</span>
                    </div>
                    <div class="b-max-w-sm b-mx-auto b-pb-3 b-text-gray-500 b-text-right b-text-sm">
                        Including taxes
                    </div>
                </section>
        </div>

    </div>

@endsection
