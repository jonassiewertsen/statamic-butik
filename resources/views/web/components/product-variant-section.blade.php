<div>
    <h1 class="font-bold text-4xl">
        {{ $variant_title }}
        @if ($stock_unlimited || $stock == 0)
            <span class="text-sm ml-2 text-danger">{{ __('butik::web.sold_out') }}</span>
        @endif
    </h1>

    <div class="text-dark text-3xl font-light mt-2">
        {{ currency() }} {{ $price }} {{ __('butik::web.total') }}
        <span class="text-sm">+ shipping</span>
    </div>

    @if ($product->variants)
        <div class="flex mt-6">
            @foreach ($product->variants as $variant)
                <button wire:click="variant('{{ $variant->original_title }}')"
                        class="block text-gray-dark text-md py-1 px-3 mr-4 bg-gray-light rounded focus:text-accent focus:outline-none"
                >
                    {{ $variant->original_title }}
                </button>
            @endforeach
        </div>
    @endif

    @if ($product->description )
        <p class="mt-8 text-dark">{{ $product->description }}</p>
    @endif

    @if ($stock_unlimited || $stock  > 0)
        <div class="flex mt-6">
            <button wire:click="addToCart()" class="flex bg-accent text-white py-4 px-5 rounded-xl">
                <img class="mr-3" src="/vendor/butik/images/bag-white.svg" alt="add to bag"> {{ __('butik::web.add_to_bag') }}
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
