@extends('butik::web.layouts.express-checkout')

@section('content')

     Header
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
        <div class="b-bg-gray-200 b-rounded b-hidden b-items-center b-w-1/2 md:b-flex">
{{--            @include('butik::web.checkout.partials.product-card')--}}
            What should be here?
        </div>

    </div>

@endsection
