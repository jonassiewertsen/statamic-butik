<div>
    @if ($stock_unlimited || $stock  > 0)
        <h1 class="b-mt-2 b-text-2xl">{{ $title }}</h1>
    @else
        <h1 class="b-mt-2 b-text-2xl">
            <s>{{ $title }}</s>
            <span class="b-text-sm b-ml-2">{{ __('butik::product.sold_out') }}</span>
        </h1>
    @endif

    <div class="b-text-gray-700 b-text-3xl b-mt-2">{{ $price }} {{ currency() }} {{ __('butik::product.total') }}</div>

    @if ($product->variants)
        <div class="b-flex">
            @foreach ($product->variants as $variant)
                <button wire:click="variant('{{ $variant->original_title }}')" class="b-block b-border b-border-black b-px-3 b-rounded b-mr-2">{{ $variant->original_title }}</button>
            @endforeach
        </div>
    @endif

    @if ($stock_unlimited || $stock  > 0)
        <div class="b-flex b-mt-5">
            <a class="b-bg-gray-900 b-flex-grow b-block b-py-2 b-rounded b-text-center b-text-white b-text-xl hover:b-bg-gray-800"
               href="{{ $product->express_delivery_url }}"
            >
                {{ __('butik::payment.express_checkout') }}
            </a>
            @livewire('butik::add-to-cart', ['product' => $product])
        </div>
    @endif
</div>
