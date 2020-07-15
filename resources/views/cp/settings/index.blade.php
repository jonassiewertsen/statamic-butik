@extends('statamic::layout')
@section('title', __('butik::setting.butik'))

@section('content')
    <div class="card p-0 content">
        <div class="py-3 px-4 border-b">
            <h1>Statamic Butik</h1>
            <p>{{ __('butik::cp.configure_after_your_needs') }}</p>
        </div>

        <div class="flex flex-wrap p-2">

            <a href="{{ cp_route('butik.countries.index') }}"
                    class="w-full lg:w-1/2 p-2 flex items-start hover:bg-grey-20 rounded-md group">
                <div class="h-8 w-8 mr-2 text-grey-80">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M19.479 8V2.5a2 2 0 0 0-2-2h-12a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h8l3 3v-3h1a2 2 0 0 0 1.721-.982"
                              fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M1.485 3.764A2 2 0 0 0 .479 5.5v16a2 2 0 0 0 2 2h8a2 2 0 0 0 1.712-.967M5.479 3.5h4m-2 4.5V3.5M15.7 7.221l-4.2-1.2 1.2 4.2 7.179 7.179a2.121 2.121 0 0 0 3-3zm3.279 9.279l3-3M12.7 10.221l3-3M12.479 3.5h4m-10 8h4m-4 3h6.5m-6.5 3h9"
                              fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="mb-1 text-blue">Countries</h3>
                    <p>Where to you want to sell your products? Create those countries you want to sell to and connect them with the shipping options.</p>
                </div>
            </a>

            <a href="{{ cp_route('butik.shipping.index') }}"
               class="w-full lg:w-1/2 p-2 flex items-start hover:bg-grey-20 rounded-md group">
                <div class="h-8 w-8 mr-2 text-grey-80">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M19.479 8V2.5a2 2 0 0 0-2-2h-12a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h8l3 3v-3h1a2 2 0 0 0 1.721-.982"
                              fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M1.485 3.764A2 2 0 0 0 .479 5.5v16a2 2 0 0 0 2 2h8a2 2 0 0 0 1.712-.967M5.479 3.5h4m-2 4.5V3.5M15.7 7.221l-4.2-1.2 1.2 4.2 7.179 7.179a2.121 2.121 0 0 0 3-3zm3.279 9.279l3-3M12.7 10.221l3-3M12.479 3.5h4m-10 8h4m-4 3h6.5m-6.5 3h9"
                              fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="mb-1 text-blue">Shipping</h3>
                    <p>Use our default shipping set up or go crazy! Your shipping options can be customized. </p>
                </div>
            </a>

            <a href="{{ cp_route('butik.taxes.index') }}"
               class="w-full lg:w-1/2 p-2 flex items-start hover:bg-grey-20 rounded-md group">
                <div class="h-8 w-8 mr-2 text-grey-80">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M19.479 8V2.5a2 2 0 0 0-2-2h-12a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h8l3 3v-3h1a2 2 0 0 0 1.721-.982"
                              fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M1.485 3.764A2 2 0 0 0 .479 5.5v16a2 2 0 0 0 2 2h8a2 2 0 0 0 1.712-.967M5.479 3.5h4m-2 4.5V3.5M15.7 7.221l-4.2-1.2 1.2 4.2 7.179 7.179a2.121 2.121 0 0 0 3-3zm3.279 9.279l3-3M12.7 10.221l3-3M12.479 3.5h4m-10 8h4m-4 3h6.5m-6.5 3h9"
                              fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="mb-1 text-blue">Taxes</h3>
                    <p>Configure your needed taxes from your home country you are selling from.</p>
                </div>
            </a>

        </div>
    </div>
@endsection
