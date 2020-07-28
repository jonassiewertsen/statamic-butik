@if ($countries->count() > 1)
    <aside class="text-right">{{ __('butik::web.ship_to') }}
        <select name="country" wire:model="country" wire:change="updateCountry">
            @foreach($countries as $code => $name)
                <option value="{{ $code }}">{{ $name }}</option>
            @endforeach
        </select>
    </aside>
@endif
