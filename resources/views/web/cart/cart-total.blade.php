<section class="w-1/2 ml-auto px-8 mt-20 text-xl">

    <div class="flex mb-12 justify-between">
        <span class="text-gray">{{ ucfirst(__('butik::web.shipping')) }}</span>
        <span>{{ currency() }} {{ $total_shipping }}</span>
    </div>

    <div class="flex justify-between mb-10">
        <span class="text-gray">{{ ucfirst(__('butik::web.total')) }}</span>
        <div class="text-right">
            <div class="text-4xl leading-none">{{ currency() }} {{ $total_price }}</div>
            <div class="text-sm text-gray">{{ __('butik::web.including_taxes') }}</div>
        </div>
    </div>

    @if ($items->count() !== 0)
        <a href="{{ route('butik.checkout.delivery') }}" class="bg-accent block mt-5 py-2 rounded text-center text-white text-xl">
            {{ ucfirst(__('butik::web.checkout')) }}
        </a>
    @endif
</section>
