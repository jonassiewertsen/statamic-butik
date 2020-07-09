<div class="b-px-6">
    <div class="b-flex b-flex-wrap b--mx-12">

        @foreach($products as $product)
            <div class="b-block b-px-12 b-mb-10 b-w-1/2 md:b-w-1/3">
                <a href="{{ $product->show_url }}" class="b-block b-text-xl b-trans b-w-full hover:b-opacity-75">

                    @if (! empty($product->images))
                        <img class="b-w-full b-rounded-xl" src="/assets/{{ $product->images[0] }}">
                    @else
                        <div class="b-w-full">
                            @include('butik::web.shop.partials.placeholder')
                        </div>
                    @endif

                    @if ($product->stock_unlimited || $product->stock  > 0)
                        <h1 class="b-mt-4 b-text-2xl b-text-center b-leading-none">{{ $product->title }}</h1>
                    @else
                        <div class="b-mt-4 b-text-center">
                            <h1><s>{{ $product->title }}</s></h1>
                            <span class="b-text-sm b-text-2xl b-ml-2">{{ __('butik::product.sold_out') }}</span>
                        </div>
                    @endif

                    <div class="b-text-gray-500 b-text-center">{{ currency() }} {{ $product->price }}</div>

                </a>
            </div>
        @endforeach
    </div>
</div>
