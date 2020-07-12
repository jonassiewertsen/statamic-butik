<div>
    @if ($stock_unlimited || $stock  > 0)
        <h1 class="b-mt-2 b-text-2xl">{{ $variant_title }}</h1>
    @else
        <h1 class="b-mt-2 b-text-2xl">
            <s>{{ $variant_title }}</s>
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
               href="{{ $express_delivery_url }}"
            >
                {{ __('butik::payment.express_checkout') }}
            </a>
            <div>
                <button wire:click="addToCart()" class="b-block b-ml-3 b-py-2 b-px-1 b-flex b-items-center b-border-2 b-border-black b-rounded">
                    <svg class="b-w-6" fill="currentColor" viewBox="0 0 20 20" class="w-8 h-8"><path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                    <svg class="b-w-8" fill="currentColor" viewBox="0 0 20 20" class="w-8 h-8"><path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"></path></svg>
                </button>
            </div>
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
