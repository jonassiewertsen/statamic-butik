@extends('butik::web.layouts.shop')

@section('content')

    <h1 class="b-block b-mb-6 b-text-center b-font-bold b-text-xl">
        {{ __('butik::cart.singular') }}
    </h1>

    @livewire('butik::cart')

@endsection


