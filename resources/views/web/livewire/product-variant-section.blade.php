<div>
    @if ($stock_unlimited || $stock  > 0)
        <h1 class="b-mt-2 b-font-bold b-text-4xl">{{ $variant_title }}</h1>
    @else
        <h1 class="b-mt-2 b-font-bold b-text-4xl">
            <s>{{ $variant_title }}</s>
            <span class="b-text-sm b-ml-2">{{ __('butik::product.sold_out') }}</span>
        </h1>
    @endif

    <div class="b-text-gray-700 b-text-3xl b-font-light b-mt-2">
        {{ currency() }} {{ $price }} {{ __('butik::product.total') }}
        <span class="b-text-sm">+ shipping</span>
    </div>

    @if ($product->variants)
        <div class="b-flex b-mt-4">
            @foreach ($product->variants as $variant)
                <button wire:click="variant('{{ $variant->original_title }}')" class="b-block b-border b-border-black b-px-3 b-rounded b-mr-2">{{ $variant->original_title }}</button>
            @endforeach
        </div>
    @endif

    @if ($product->description )
        <p class="b-mt-8 b-text-gray-700">{{ $product->description }}</p>
    @endif

    @if ($stock_unlimited || $stock  > 0)
        <div class="b-flex b-mt-5">
            <a class="b-bg-gray-900 b-flex-grow b-block b-py-2 b-rounded b-text-center b-text-white b-text-xl hover:b-bg-gray-800"
               href="{{ $express_delivery_url }}"
            >
                {{ __('butik::payment.express_checkout') }}
            </a>
            <button wire:click="addToCart()" class="b-inline-block b-ml-5 b-bg-gray-300 b-py-4 b-px-5 b-rounded-xl">
                Add to bag
            </button>
        </div>
    @endif
</div>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
        window.livewire.on('urlChange', (url) => {
            history.pushState(null, null, url);
        });
    });
</script>
