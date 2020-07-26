@if ($countries->count() > 1)
    <aside class="text-right">{{ __('butik::web.ship_to') }}
        <select name="country" wire:model="countrySlug">
            @foreach($countries as $slug => $name)
                <option value="{{ $slug }}" @if($name == $country) selected @endif>{{ $name }}</option>
            @endforeach
        </select>
    </aside>
@endif
