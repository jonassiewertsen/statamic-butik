<div class="b-mx-auto b-my-10">
    <div class="b-flex b-justify-center b-mt-5">
        @if (! empty($product->images))
            <img class="b-w-1/2" src="/assets/{{ $product->images->first() }}">
        @else
            <div class="b-w-full">
                @include('butik::web.shop.partials.placeholder')
            </div>
        @endif
    </div>

    <section class="b-px-10">
        <h3 class="b-font-bold b-block b-mt-5 b-text-3xl b-text-center">{{ $product->title }}</h3>

        <hr class="b-border-white b-my-5">

        <div class="b-flex b-my-3 b-justify-between b-max-w-sm b-mx-auto">
            <span>{{ __('butik::payment.subtotal') }}</span>
            <span>{{ currency() }} {{ $product->base_price }}</span>
        </div>

        <div class="b-flex b-my-3 b-justify-between b-max-w-sm b-mx-auto">
            <span>{{ __('butik::payment.shipping') }}</span>
            <span>{{ currency() }} {{ $product->shipping_amount }}</span>
        </div>

        <hr class="b-border-white b-my-5">

        <div class="b-flex b-mt-3 b-justify-between b-max-w-sm b-mx-auto">
            <span>{{ __('butik::payment.total') }}</span>
            <span class="b-font-black">{{ currency() }} {{ $product->total_price }}</span>
        </div>
        <div class="b-max-w-sm b-mx-auto b-pb-3 b-text-gray-500 b-text-right b-text-sm">
            Including {{ $product->tax_percentage }}% taxes ({{ $product->tax_amount }} {{ currency() }})
        </div>

    </section>
</div>
