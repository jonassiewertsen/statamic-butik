<section class="w-1/2 ml-auto px-8 m16">
    <h3 class="font-bold block mt-8 text-3xl text-center">
        {{ ucfirst(__('butik::web.total')) }}
    </h3>

    <hr class="border-gray-200 my-5">

    <div class="flex my-3 justify-between max-w-sm mx-auto">
        <span>{{ ucfirst(__('butik::web.shipping')) }}</span>
        <span>{{ currency() }} {{ $total_shipping }}</span>
    </div>

    <hr class="border-gray-200 my-5">

    <div class="flex mt-3 justify-between max-w-sm mx-auto">
        <span>{{ ucfirst(__('butik::web.total')) }}</span>
        <span class="font-black">{{ currency() }} {{ $total_price }}</span>
    </div>
    <div class="max-w-sm mx-auto p3 text-gray-500 text-right text-sm">
        {{ __('butik::web.including_taxes') }}
    </div>

    @if ($items->count() !== 0)
        <a href="{{ route('butik.checkout.delivery') }}" class="bg-gray-900 block mt-5 py-2 rounded text-center text-white text-xl hover:bg-gray-800">
            {{ ucfirst(__('butik::web.checkout')) }}
        </a>
    @endif
</section>
