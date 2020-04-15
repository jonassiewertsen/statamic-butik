<div class="b-bg-gray-100 b-flex b-w-full b-rounded b-px-8 b-py-5 b-mb-6">
    <header class="b-w-40 b-w-1/5">
        @include('butik::web.shop.partials.placeholder')
    </header>
    <section class="b-w-4/5 b-ml-12">
        <h3 class="b-font-bold b-block b-mt-5 b-text-2xl">{{ $item->name }}</h3>

        <hr class="b-border-white b-my-3">

        <p>Aufblasbares Stand Up Paddle von Indiana Jahrgang 2019 gebraucht in super Zustand mit Kids Paddel, Tasche, Finne, Pumpe und Rep Kit kann gerne vor Ort getestet werden</p>

        <hr class="b-border-white b-my-3">

        <footer class="b-flex b-justify-end b-items-center">
            <span class="">$ 236</span>
            <figure class="b-ml-10">
                <button wire:click="reduce('{{ $item->id }}')" class="b-bg-gray-400 b-px-4 b-py-1 b-rounded-full">-</button>
                <span class="b-bg-gray-400 b-px-4 b-py-1 b-rounded-full">{{ $item->quantity }}</span>
                <button wire:click="add('{{ $item->id }}')" class="b-bg-gray-400 b-px-4 b-py-1 b-rounded-full">+</button>
            </figure>
            <strong class="b-ml-10">$ 236</strong>
        </footer>
    </section>
</div>
