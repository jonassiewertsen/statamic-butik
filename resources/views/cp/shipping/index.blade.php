@extends('statamic::layout')
@section('title', ucfirst(__('butik::cp.shipping_plural')))
@section('wrapper_class', 'max-w-lg')

@section('content')

    <div class="flex mb-3">
        <h1 class="flex-1">{{ __('butik::cp.shipping_plural') }}</h1>
    </div>

    <butik-shipping-overview
        :shipping-profile-create-title="'{{ __('butik::cp.shipping_form_create') }}'"
        :shipping-profile-route="'{{ cp_route('butik.shipping-profiles.index') }}'"
        :shipping-profile-blueprint='@json($shippingProfileBlueprint)'
        :shipping-profile-values='@json($shippingProfileValues)'
        :shipping-profile-meta='@json($shippingProfileMeta)'

        :shipping-zone-route="'{{ cp_route('butik.shipping-zones.store') }}'"
        :shipping-zone-create-title="'{{ __('butik::shipping.create_zone') }}'"
        :shipping-zone-blueprint='@json($shippingZoneBlueprint)'
        :shipping-zone-values='@json($shippingZoneValues)'
        :shipping-zone-meta='@json($shippingZoneMeta)'

        :shipping-rate-route="'{{ cp_route('butik.shipping-rates.store') }}'"
        :shipping-rate-create-title="'{{ __('butik::cp.shipping_rate_form_create') }}'"
        :shipping-rate-blueprint='@json($shippingRateBlueprint)'
        :shipping-rate-values='@json($shippingRateValues)'
        :shipping-rate-meta='@json($shippingRateMeta)'

        :country-shipping-zone-route="'{{ cp_route('butik.country-shipping-zone.index', 'xxx') }}'"
    ></butik-shipping-overview>

@endsection
