<div>
    <h1 class="b-block b-mb-6 b-text-center b-font-bold b-text-xl">
        {{ __('butik::web.bag') }}
    </h1>

    <main class="b-px-8">
        <aside class="b-text-right b-mb-3">{{ __('butik::web.ship_to') }}
            <select name="country" wire:model="country">
                @foreach($countries as $slug => $name)
                    <option value="{{ $slug }}" @if($name == $country) selected @endif>{{ $name }}</option>
                @endforeach
            </select>
        </aside>

        @forelse ($items as $item)
            @include('butik::web.cart.partials.card')
        @empty
            <div class="b-bg-gray-100 b-flex b-w-full b-rounded b-px-8 b-py-5 b-mb-6">
                <p><strong>{{ __('butik::web.bag_empty') }}</strong></p>
            </div>
        @endforelse

    </main>

    @include('butik::web.cart.partials.total')
</div>
