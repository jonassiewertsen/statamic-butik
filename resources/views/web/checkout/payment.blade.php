@extends('butik::web.layouts.express-checkout')

@section('content')

    @include('butik::web.checkout.partials.status', ['review' => true])

    <hr class="b-mb-5 b-mt-8">

    <h1 class="b-block b-mb-6 b-text-center b-font-bold b-text-xl">
        {{ __('butik::checkout.name') }}
    </h1>

    {{-- body--}}
    <div class="b-flex b-flex-col-reverse lg:b-flex-row b-px-5 lg:b-px-0  b-mb-20 b-mt-6">
        <div class="b-w-full b-mr-10 lg:b-ml-5 lg:b-px-0 lg:b-w-1/2 xl:b-ml-0">

            {{-- ship to card --}}
            @include('butik::web.checkout.partials.ship-to-card')

            {{-- pay now button --}}
            <a href="#"
               rel="nofollow"
               class="b-block b-w-full b-mt-3 b-bg-gray-900 b-mt-6 b-py-2 b-rounded b-text-center b-text-white b-text-xl hover:b-bg-gray-800">
                {{ __('butik::payment.pay_now') }}
            </a>
        </div>

        {{-- Product listing --}}
        <div class="b-bg-gray-200 b-px-10 b-py-8 b-w-full lg:b-w-1/2">

            <section class="b-flex b-mt-3f">
                <figure class="b-w-1/5 b-mr-5">
                    @if (! empty($product->images))
                        <img class="b-w-1/2" src="/assets/{{ $product->images->first() }}">
                    @else
                        <div class="b-w-full">
                            @include('butik::web.shop.partials.placeholder')
                        </div>
                    @endif
                </figure>

                <div class="b-w-full">
                    <h3 class="b-font-bold">Product title</h3>
                    <p>Eine kurze Beschreibung um ...</p>
                    <div class="b-flex b-justify-end b-items-baseline">
                        <span class="b-mr-5 b-text-sm b-italic">25,5 € x 2</span>
                        <span class="b-font-bold">56 €</span>
                    </div>
                </div>
            </section>

            <section class="b-flex b-mt-3f">
                <figure class="b-w-1/5 b-mr-5">
                    @if (! empty($product->images))
                        <img class="b-w-1/2" src="/assets/{{ $product->images->first() }}">
                    @else
                        <div class="b-w-full">
                            @include('butik::web.shop.partials.placeholder')
                        </div>
                    @endif
                </figure>

                <div class="b-w-full">
                    <h3 class="b-font-bold">Product title</h3>
                    <p>Eine kurze Beschreibung um ...</p>
                    <div class="b-flex b-justify-end b-items-baseline">
                        <span class="b-mr-5 b-text-sm b-italic">25,5 € x 2</span>
                        <span class="b-font-bold">56 €</span>
                    </div>
                </div>
            </section>

            <section class="b-flex b-mt-3f">
                <figure class="b-w-1/5 b-mr-5">
                    @if (! empty($product->images))
                        <img class="b-w-1/2" src="/assets/{{ $product->images->first() }}">
                    @else
                        <div class="b-w-full">
                            @include('butik::web.shop.partials.placeholder')
                        </div>
                    @endif
                </figure>

                <div class="b-w-full">
                    <h3 class="b-font-bold">Product title</h3>
                    <p>Eine kurze Beschreibung um ...</p>
                    <div class="b-flex b-justify-end b-items-baseline">
                        <span class="b-mr-5 b-text-sm b-italic">25,5 € x 2</span>
                        <span class="b-font-bold">56 €</span>
                    </div>
                </div>
            </section>


            <section class="b-w-full b-mt-4">

                <h3 class="b-font-bold b-block b-mt-5 b-text-3xl b-text-center">Total</h3>

                <hr class="b-border-white b-my-5">

                <div class="b-flex b-my-3 b-justify-between b-max-w-sm b-mx-auto">
                    <span>{{ __('butik::payment.shipping') }}</span>
                    <span>5555555</span>
                </div>

                <hr class="b-border-white b-my-5">

                <div class="b-flex b-mt-3 b-justify-between b-max-w-sm b-mx-auto">
                    <span>{{ __('butik::payment.total') }}</span>
                    <span class="b-font-black">4344553</span>
                </div>
                <div class="b-max-w-sm b-mx-auto b-pb-3 b-text-gray-500 b-text-right b-text-sm">
                    Including taxes
                </div>
            </section>
        </div>
    </div>

@endsection

