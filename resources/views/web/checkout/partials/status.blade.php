<div class="b-mx-5">
    <div class="b-flex b-justify-around">
        @if (isset($delivery))
            <div class="b-text-xs b-flex b-flex-col b-items-center">
                <div class="b-border-2 b-border-green-500 b-flex b-h-8 b-items-center b-justify-center b-rounded-full b-w-8">1</div>
                <span class="b-text-green-500 b-mt-1">{{ __('butik::payment.delivery') }}</span>
            </div>
        @else
            <div class="b-text-xs b-flex b-flex-col b-items-center">
                <div class="b-border-2 b-border-gray-400 b-flex b-h-8 b-items-center b-justify-center b-rounded-full b-w-8">1</div>
                <span class="b-text-gray-400 b-mt-1">{{ __('butik::payment.delivery') }}</span>
            </div>
        @endif

        @if (isset($review))
            <div class="b-text-xs b-flex b-flex-col b-items-center">
                <div class="b-border-2 b-border-green-500 b-flex b-h-8 b-items-center b-justify-center b-rounded-full b-w-8">2</div>
                <span class="b-text-green-500 b-mt-1">{{ __('butik::payment.review_payment') }}</span>
            </div>
        @else
            <div class="b-text-xs b-flex b-flex-col b-items-center">
                <div class="b-border-2 b-border-gray-400 b-flex b-h-8 b-items-center b-justify-center b-rounded-full b-w-8">2</div>
                <span class="b-text-gray-400 b-mt-1">{{ __('butik::payment.review_payment') }}</span>
            </div>
        @endif

        @if (isset($receipt))
            <div class="b-text-xs b-flex b-flex-col b-items-center">
                <div class="b-border-2 b-border-green-500 b-flex b-h-8 b-items-center b-justify-center b-rounded-full b-w-8">3</div>
                <span class="b-text-green-500 b-mt-1">{{ __('butik::payment.receipt') }}</span>
            </div>
        @else
            <div class="b-text-xs b-flex b-flex-col b-items-center">
                <div class="b-border-2 b-border-gray-400 b-flex b-h-8 b-items-center b-justify-center b-rounded-full b-w-8">3</div>
                <span class="b-text-gray-500 b-mt-1">{{ __('butik::payment.receipt') }}</span>
            </div>
        @endif
    </div>
</div>
