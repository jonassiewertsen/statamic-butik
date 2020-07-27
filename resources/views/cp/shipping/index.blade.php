@extends('statamic::layout')
@section('title', ucfirst(__('butik::cp.shipping_plural')))
@section('wrapper_class', 'max-w-lg')

@section('content')

    <div class="flex mb-3">
        <h1 class="flex-1">{{ ucfirst(__('butik::cp.shipping_plural')) }}</h1>
    </div>

    <butik-shipping-overview
        :shipping-profile-create-title="'{{ __('butik::cp.shipping_form_create') }}'"
        :shipping-profile-route="'{{ cp_route('butik.shipping-profiles.index') }}'"
        :shipping-profile-blueprint='@json($shippingProfileBlueprint)'
        :shipping-profile-values='@json($shippingProfileFields->values())'
        :shipping-profile-meta='@json($shippingProfileFields->meta())'

        :shipping-zone-route="'{{ cp_route('butik.shipping-zones.store') }}'"
        :shipping-zone-create-title="'{{ __('butik::shipping.create_zone') }}'"
        :shipping-zone-blueprint='@json($shippingZoneBlueprint)'
        :shipping-zone-values='@json($shippingZoneFields->values())'
        :shipping-zone-meta='@json($shippingZoneFields->meta())'

        :shipping-rate-route="'{{ cp_route('butik.shipping-rates.store') }}'"
        :shipping-rate-create-title="'{{ __('butik::cp.shipping_rate_form_create') }}'"
        :shipping-rate-blueprint='@json($shippingRateBlueprint)'
        :shipping-rate-values='@json($shippingRateFields->values())'
        :shipping-rate-meta='@json($shippingRateFields->meta())'

    ></butik-shipping-overview>

@endsection
