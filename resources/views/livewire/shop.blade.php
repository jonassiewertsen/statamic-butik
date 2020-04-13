<div>
    <div class="b-mb-8 b-px-5 b-w-full b-flex b-justify-center">
        <input wire:model="search" wire:transition.fade type="text" placeholder="Search your product here" class="b-border b-max-w-lg b-shadow b-w-full b-outline-none b-rounded b-text-center b-py-2 b-text-gray-700">
    </div>

    <div class="b-flex b-flex-wrap b-pr-5">

        @foreach($products as $product)
            <div class="b-block b-mb-10 b-pl-5 b-w-1/2 md:b-w-1/3">
                <a href="{{ $product->show_url }}" class="b-block b-text-xl b-trans b-w-full hover:b-opacity-75">

                    @if (! empty($product->images))
                        <img class="b-w-full" src="/assets/{{ $product->images->first() }}">
                    @else
                        <div class="b-w-full">
                            @include('butik::web.shop.partials.placeholder')
                        </div>
                    @endif

                    @if ($product->stock_unlimited || $product->stock  > 0)
                        <h1 class="b-mt-2">{{ $product->title }}</h1>
                    @else
                        <div class="b-mt-2">
                            <s>{{ $product->title }}</s>
                            <span class="b-text-sm b-ml-2">sold out</span>
                        </div>
                    @endif

                    <div class="b-text-gray-500 b-text-sm">{{ $product->base_price }}</div>
                    <!-- TODO: Get the price symbol and total price back -->

                </a>
            </div>
        @endforeach
    </div>
</div>
