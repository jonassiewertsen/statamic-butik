<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Shop | {{ config('app.name') }}</title>

        <link rel="stylesheet" href="/vendor/butik/css/statamic-butik.css">
        @livewireStyles
    </head>

    <body>
        <div class="b-max-w-6xl b-mx-auto">
            <header class="b-flex b-px-5 b-py-8 md:b-py-10">
                <a class="b-w-full" href="{{ route('butik.shop') }}">
                    <img class="b-w-3/5" style="max-width: 200px;" src="/vendor/butik/images/logo.svg">
                </a>
                @livewire('butik::cart-icon')
            </header>

            <main class="b-w-full">

                @yield('content')

            </main>
        </div>

        <hr class="b-mt-8">

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
