<form method="post" action="#heading" class="b-pl-5 b-mr-10 b-w-full md:b-w-1/2">
    <h2 class="b-text-md b-uppercase" id="heading">{{ __('butik::payment.your_information') }}</h2>

    @csrf

    <label for="name" class="b-block b-my-3">
        <div class="b-font-bold b-text-g b-text-xs">{{ __('butik::payment.name') }}</div>
        <input id="name" name="name" type="text" value="{{ old('name') ?? $customer->name }}" autofocus class="b-border-b b-border-gray-900 b-my-3 b-px-2 b-py-1 b-w-full">
        @error('name')
            <span class="b-text-red-600 b-block b--mt-2 b-text-xs">{{ $message }}</span>
        @enderror
    </label>

    <label for="mail" class="b-block b-my-3">
        <div class="b-font-bold b-text-g b-text-xs">{{ __('butik::payment.mail') }}</div>
        <input id="mail" name="mail" type="mail" value="{{ old('mail') ?? $customer->mail }}" class="b-border-b b-border-gray-900 b-my-3 b-px-2 b-py-1 b-w-full">
        @error('mail')
            <span class="b-text-red-600 b-block b--mt-2 b-text-xs">{{ $message }}</span>
        @enderror
    </label>

    <div class="b-mb-6 b-text-gray-600 b-text-xs">
        {!! __('butik::payment.account_creation') !!}
    </div>

    <h2 class="b-text-md b-uppercase">{{ __('butik::payment.delivery_address') }}</h2>

    <label for="country" class="b-block b-my-3">
        <div class="b-font-bold b-text-g b-text-xs">{{ __('butik::payment.country') }}</div>
        <select id="country" name="country" class="b-border-b b-border-gray-900 b-my-3 b-px-2 b-py-1 b-w-full">
            @foreach($countries as $slug => $name)
                <option value="{{ $slug }}" @if($selected_country['slug'] == $slug) selected @endif>{{ $name }}</option>
            @endforeach
        </select>

        @error('country')
            <span class="b-text-red-600 b-block b--mt-2 b-text-xs">{{ $message }}</span>
        @enderror
    </label>

    <label for="address1" class="b-block b-my-3">
        <div class="b-font-bold b-text-g b-text-xs">{{ __('butik::payment.address1') }}</div>
        <input id="address1" name="address1" type="text" value="{{ old('address1') ?? $customer->address1 }}" class="b-border-b b-border-gray-900 b-my-3 b-px-2 b-py-1 b-w-full">
        @error('address1')
            <span class="b-text-red-600 b-block b--mt-2 b-text-xs">{{ $message }}</span>
        @enderror
    </label>

    <label for="address2" class="b-block b-my-3">
        <div class="b-font-bold b-text-g b-text-xs">{{ __('butik::payment.address2') }}</div>
        <input id="address2" name="address2" type="text" value="{{ old('address2') ?? $customer->address2 }}" class="b-border-b b-border-gray-900 b-my-3 b-px-2 b-py-1 b-w-full">
        @error('address2')
            <span class="b-text-red-600 b-block b--mt-2 b-text-xs">{{ $message }}</span>
        @enderror
    </label>

    <label for="city" class="b-block b-my-3">
        <div class="b-font-bold b-text-g b-text-xs">{{ __('butik::payment.city') }}</div>
        <input id="city" name="city" type="text" value="{{ old('city') ?? $customer->city }}" class="b-border-b b-border-gray-900 b-my-3 b-px-2 b-py-1 b-w-full">
        @error('city')
            <span class="b-text-red-600 b-block b--mt-2 b-text-xs">{{ $message }}</span>
        @enderror
    </label>

    <label for="zip" class="b-block b-my-3">
        <div class="b-font-bold b-text-g b-text-xs">{{ __('butik::payment.zip') }}</div>
        <input id="zip" name="zip" type="text" value="{{ old('zip') ?? $customer->zip }}" class="b-border-b b-border-gray-900 b-my-3 b-px-2 b-py-1 b-w-full">
        @error('zip')
            <span class="b-text-red-600 b-block b--mt-2 b-text-xs">{{ $message }}</span>
        @enderror
    </label>

    <div class="b-flex b-justify-end flex">
        <button type="submit" class="b-bg-gray-900 b-block b-mt-3 b-px-6 b-py-2 b-rounded b-text-center b-text-white b-text-xl hover:b-bg-gray-800">
            {{ __('butik::payment.to_payment') }}
        </button>
    </div>
</form>
