<section class="{{ $item->sellable ? '' : 'bg-danger-light' }} flex border-gray-light border-b pb-8 mb-8 w-full">
    <main class="flex flex-1 items-center">
        @if ($item->images->count() > 0)
            <img class="w-40 h-40 rounded-xl shadow object-cover mr-5" src="/assets/{{ $item->images[0]->path() }}">
        @else
            <div class="flex items-center w-40 h-40 rounded-xl shadow object-cover mr-5">
                @include('butik::web.components.placeholder-image')
            </div>
        @endif
        <div>
            <h3 class="font-bold text-dark block text-2xl">{{ $item->name }}</h3>
            <span class="text-gray text-xl">{{ currency() }} {{ $item->singlePrice() }}</span>
        </div>
    </main>
    <aside class="flex align-center pl-20">
        <div class="flex flex-col items-end justify-center">
            <span class="block font-bold text-2xl">{{ $item->getQuantity() }}</span>
            <span class="text-gray text-xl">
                @if ($item->sellable)
                    {{ currency() }} {{ $item->totalPrice() }}
                @else
                    <s>{{ currency() }} {{ $item->totalPrice() }}</s>
                @endif
            </span>
        </div>
        <div class="flex flex-col justify-center leading-none pl-6 text-3xl text-gray">
            <button wire:click="add('{{ $item->slug }}')" class="border px-2 py-1 rounded-t">+</button>
            <button wire:click="reduce('{{ $item->slug }}')" class="border-b px-2 py-1 border-l border-r rounded-b">-</button>
        </div>
    </aside>

</section>

@if (! $item->sellable)
    <p>{{ __('butik::web.not_available_in_country') }}</p>
@endif
