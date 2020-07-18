<div class="{{ $item->sellable ? 'bg-gray-100' : 'bg-red-200' }} flex w-full rounded px-8 py-5 m6">
    <header class="w-40 w-1/5">
        @if (! empty($item->images))
            <img src="/assets/{{ $item->images[0] }}">
        @else
            <div class="w-full">
                @include('butik::web.shop.partials.placeholder')
            </div>
        @endif
    </header>
    <section class="flex flex-col justify-between ml-12 w-4/5">
        <div>
            <h3 class="font-bold block mt-5 text-2xl">{{ $item->name }}</h3>
            @if ($item->description)
                <hr class="border-white my-3">
                @if ($item->sellable)
                    <p>{{ $item->description }}</p>
                @else
                    <p>{{ __('butik::web.not_available_in_country') }}</p>
                @endif
                <hr class="border-white my-3">
            @endif

        </div>

        <footer class="flex justify-end items-center">
            <span class="">{{ currency() }} {{ $item->singlePrice() }}</span>
            <figure class="flex items-center ml-10">
                <button wire:click="reduce('{{ $item->slug }}')" class="bg-gray-300 flex font-bold h-8 justify-center py-1 rounded-full text-gray-600 w-8 hover:bg-gray-400">-</button>
                <span class="px-3">{{ $item->getQuantity() }}</span>
                <button wire:click="add('{{ $item->slug }}')" class="bg-gray-300 flex font-bold h-8 justify-center py-1 rounded-full text-gray-600 w-8 hover:bg-gray-400">+</button>
            </figure>
            <strong class="ml-10">
                @if ($item->sellable)
                    {{ currency() }} {{ $item->totalPrice() }}
                @else
                    <s>{{ currency() }} {{ $item->totalPrice() }}</s>
                @endif
            </strong>
        </footer>
    </section>
</div>
