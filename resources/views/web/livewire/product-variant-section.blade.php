<div>
    @if ($stock_unlimited || $stock  > 0)
        <h1 class="mt-2 font-bold text-4xl">{{ $variant_title }}</h1>
    @else
        <h1 class="mt-2 font-bold text-4xl">
            <s>{{ $variant_title }}</s>
            <span class="text-sm ml-2">{{ __('butik::web.sold_out') }}</span>
        </h1>
    @endif

    <div class="text-gray-700 text-3xl font-light mt-2">
        {{ currency() }} {{ $price }} {{ __('butik::web.total') }}
        <span class="text-sm">+ shipping</span>
    </div>

    @if ($product->variants)
        <div class="flex mt-4">
            @foreach ($product->variants as $variant)
                <button wire:click="variant('{{ $variant->original_title }}')" class="block border border-black px-3 rounded mr-2">{{ $variant->original_title }}</button>
            @endforeach
        </div>
    @endif

    @if ($product->description )
        <p class="mt-8 text-gray-700">{{ $product->description }}</p>
    @endif

    @if ($stock_unlimited || $stock  > 0)
        <div class="flex mt-5">
            <a class="bg-gray-900 flex-grow block py-2 rounded text-center text-white text-xl hover:bg-gray-800"
               href="#"
            >
                {{ __('butik::web.proceed_to_checkout') }}
            </a>
            <button wire:click="addToCart()" class="inline-block ml-5 bg-gray-300 py-4 px-5 rounded-xl">
                {{ __('butik::web.add_to_bag') }}
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
