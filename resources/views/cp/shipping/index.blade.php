@extends('statamic::layout')
@section('title', __('butik::shipping.index'))
@section('wrapper_class', 'max-w-lg')

@section('content')

    <div class="flex mb-3">
        <h1 class="flex-1">{{ __('butik::shipping.singular') }}</h1>
    </div>

    <butik-shipping-overview
        :index-shipping-profile-route="'{{ cp_route('butik.shipping-profiles.index') }}'"
        :create-shipping-profile-title="'{{ __('butik::shipping.create_profile') }}'"
        :create-shipping-profile-route="'{{ cp_route('butik.shipping-profiles.store') }}'"
        :shipping-profile-blueprint='@json($shippingProfileBlueprint)'
        :shipping-profile-values='@json($shippingProfileValues)'
        :shipping-profile-meta='@json($shippingProfileMeta)'
        :create-shipping-zone-title="'{{ __('butik::shipping.create_zone') }}'"
        :create-shipping-zone-route="'{{ cp_route('butik.shipping-zones.store') }}'"
        :shipping-zone-blueprint='@json($shippingZoneBlueprint)'
        :shipping-zone-values='@json($shippingZoneValues)'
        :shipping-zone-meta='@json($shippingZoneMeta)'
    ></butik-shipping-overview>

@endsection
