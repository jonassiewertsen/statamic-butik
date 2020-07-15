<div class="{{ $item->sellable ? 'b-bg-gray-100' : 'b-bg-red-200' }} b-flex b-w-full b-rounded b-px-8 b-py-5 b-mb-6">
    <header class="b-w-40 b-w-1/5">
        @if (! empty($item->images))
            <img src="/assets/{{ $item->images[0] }}">
        @else
            <div class="b-w-full">
                @include('butik::web.shop.partials.placeholder')
            </div>
        @endif
    </header>
    <section class="b-flex b-flex-col b-justify-between b-ml-12 b-w-4/5">
        <div>
            <h3 class="b-font-bold b-block b-mt-5 b-text-2xl">{{ $item->name }}</h3>
            @if ($item->description)
                <hr class="b-border-white b-my-3">
                @if ($item->sellable)
                    <p>{{ $item->description }}</p>
                @else
                    <p>{{ __('butik::web.not_available_in_country') }}</p>
                @endif
                <hr class="b-border-white b-my-3">
            @endif

        </div>

        <footer class="b-flex b-justify-end b-items-center">
            <span class="">{{ currency() }} {{ $item->singlePrice() }}</span>
            <figure class="b-flex b-items-center b-ml-10">
                <button wire:click="reduce('{{ $item->slug }}')" class="b-bg-gray-300 b-flex b-font-bold b-h-8 b-justify-center b-py-1 b-rounded-full b-text-gray-600 b-w-8 hover:b-bg-gray-400">-</button>
                <span class="b-px-3">{{ $item->getQuantity() }}</span>
                <button wire:click="add('{{ $item->slug }}')" class="b-bg-gray-300 b-flex b-font-bold b-h-8 b-justify-center b-py-1 b-rounded-full b-text-gray-600 b-w-8 hover:b-bg-gray-400">+</button>
            </figure>
            <strong class="b-ml-10">
                @if ($item->sellable)
                    {{ currency() }} {{ $item->totalPrice() }}
                @else
                    <s>{{ currency() }} {{ $item->totalPrice() }}</s>
                @endif
            </strong>
        </footer>
    </section>
</div>
