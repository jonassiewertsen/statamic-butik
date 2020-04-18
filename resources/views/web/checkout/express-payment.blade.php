@extends('butik::web.layouts.express-checkout')

@section('content')

    @include('butik::web.checkout.partials.status', ['review' => true])

    <hr class="b-mb-5 b-mt-8">

    <h1 class="b-block b-mb-6 b-text-center b-font-bold b-text-xl">
        {{ __('butik::payment.express_checkout') }}
    </h1>

    {{-- body --}}
    <div class="b-flex b-flex-col-reverse lg:b-flex-row b-px-5 lg:b-px-0  b-mb-20 b-mt-6">
        <div class="b-w-full b-mr-10 lg:b-ml-5 lg:b-px-0 lg:b-w-1/2 xl:b-ml-0">

            {{-- ship to card --}}
            @include('butik::web.checkout.partials.ship-to-card')

            {{-- pay now button --}}
            <a href="{{ route('butik.payment.process', $product) }}"
               rel="nofollow"
               class="b-block b-w-full b-mt-3 b-bg-gray-900 b-mt-6 b-py-2 b-rounded b-text-center b-text-white b-text-xl hover:b-bg-gray-800">
                {{ __('butik::payment.pay_now') }}
            </a>
        </div>

        {{-- Product card --}}
        <div class="b-bg-gray-200 b-flex b-items-center lg:b-pl-10 b-w-full lg:b-w-1/2">
            @include('butik::web.checkout.partials.product-card') }}
        </div>
    </div>

@endsection

