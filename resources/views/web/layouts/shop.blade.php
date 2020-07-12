<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Shop | {{ config('app.name') }}</title>

        <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="/vendor/butik/css/statamic-butik.css">
        @livewireStyles
    </head>

    <body style="font-family: 'Nunito Sans', sans-serif;">
        <div class="b-max-w-6xl b-mx-auto">
            <header class="b-flex b-justify-between b-w-full b-py-8 b-px-5 md:b-py-10">
                <button class="b-px-2">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 12H21" stroke="#2D3748" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M3 6H21" stroke="#2D3748" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M3 18H21" stroke="#2D3748" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
                <a href="{{ route('butik.shop') }}">
                    <img alt="Butik - a loveable ecommerece solution for Statamic V3" src="/vendor/butik/images/logo.svg">
                </a>
                @livewire('butik::cart-icon')
            </header>

            <main class="b-mt-8 md:b-mt-12 b-px-6">
                @yield('content')
            </main>
        </div>

        <footer class="b-flex b-justify-center b-max-w-6xl b-mx-auto b-py-10">
            <div class="b-flex b-flex-wrap b-justify-center b-text-gray-600">
                <a class="b-mx-6 b-mb-2" href="#">Impressum</a>
                <a class="b-mx-6 b-mb-2" href="#">Datenschutzerklaerung</a>
                <a class="b-mx-6 b-mb-2" href="#">Kontakt</a>
                <a class="b-mx-6 b-mb-2" href="#">Versand</a>
                <a class="b-mx-6 b-mb-2" href="#">AGB</a>
            </div>
        </footer>

        @livewireScripts
    </body>
</html>
