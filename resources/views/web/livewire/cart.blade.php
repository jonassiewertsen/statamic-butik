<div>
    <h1 class="block m6 text-center font-bold text-xl">
        {{ __('butik::web.bag') }}
    </h1>

    <main class="px-8">
        <aside class="text-right m3">{{ __('butik::web.ship_to') }}
            <select name="country" wire:model="country">
                @foreach($countries as $slug => $name)
                    <option value="{{ $slug }}" @if($name == $country) selected @endif>{{ $name }}</option>
                @endforeach
            </select>
        </aside>

        @forelse ($items as $item)
            @include('butik::web.cart.partials.card')
        @empty
            <div class="bg-gray-100 flex w-full rounded px-8 py-5 m6">
                <p><strong>{{ __('butik::web.bag_empty') }}</strong></p>
            </div>
        @endforelse

    </main>

    @include('butik::web.cart.partials.total')
</div>
