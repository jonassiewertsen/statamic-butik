<div class="b-bordeer b-border b-border-gray-500 b-px-6 b-py-3 b-mt-8 lg:b-mt-0 b-rounded-md">
    <h3 class="b-underline">{{ __('butik::payment.ship_to') }}</h3>
    <div>
        <span class="b-font-bold">{{ __('butik::payment.name') }}</span>
        <span>{{ $customer->name }}</span>
    </div>
    <div class="b-mb-2">
        <span class="b-font-bold">{{ __('butik::payment.mail') }}</span>
        <span>{{ $customer->mail }}</span>
    </div>

    <div>
        <span class="b-font-bold">{{ __('butik::payment.address1') }}</span>
        <span>{{ $customer->address1 }}</div>
    @if (isset($custom->address2))
    <div>
        <span class="b-font-bold">{{ __('butik::payment.address2') }}</span>
        <span>{{ $customer->address2 }}</span>
    </div>
    @endif
    <div>
        <span class="b-font-bold">{{ __('butik::payment.city') }}</span>
        <span>{{ $customer->city }}</span>
    </div>
    <div>
        <span class="b-font-bold">{{ __('butik::payment.zip') }}</span>
        <span>{{ $customer->zip }}</span>
    </div>
    <div>
        <span class="b-font-bold">{{ __('butik::payment.country') }}</span>
        <span>{{ $customer->country }}</span>
    </div>
</div>
