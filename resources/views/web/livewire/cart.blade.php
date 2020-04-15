<div>
    <main class="b-px-8">

        @forelse ($items as $item)
            @include('butik::web.cart.partials.card')
        @empty
            <div class="b-bg-gray-100 b-flex b-w-full b-rounded b-px-8 b-py-5 b-mb-6">
                <p><strong>{{ __('butik::cart.empty') }}</strong></p>
            </div>
        @endforelse

    </main>

{{--    @include('butik::web.cart.partials.total')--}}
</div>
