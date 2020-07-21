<div>
    <h1 class="block pl-10 font-bold text-dark text-4xl">
        {{ __('butik::web.bag') }}
    </h1>

    <main class="px-8">
        @include('butik::web.cart.country-select')

        @forelse ($items as $item)
            @include('butik::web.cart.cart-item')
        @empty
            <div class="flex w-full rounded px-8 py-5 m6">
                <p><strong>{{ __('butik::web.bag_empty') }}</strong></p>
            </div>
        @endforelse

    </main>

    @include('butik::web.cart.cart-total')
</div>
