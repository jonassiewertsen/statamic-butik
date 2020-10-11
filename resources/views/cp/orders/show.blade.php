@extends('statamic::layout')
@section('title', 'Test')

@section('content')
    <h2 class="mt-4 mb-2 font-bold text-xl">{{ __('butik::cp.order_singular') }} {{ $order->number }}</h2>
    <div class="card p-0">
        <table class="data-table">
            <tr>
                <th class="pl-2 py-1 w-1/4">{{ __('butik::cp.order_singular') }} {{ __('butik::cp.id') }}</th>
                <td>{{ $order->id }}</td>
            </tr>
            <tr>
                <th class="pl-2 py-1 w-1/4">{{ __('butik::cp.order_singular') }} {{ __('butik::cp.order_number') }}</th>
                <td>{{ $order->number }}</td>
            </tr>
            <tr>
                <th class="pl-2 py-1 w-1/4">{{ __('butik::cp.status') }}</th>
                <td>{{ $order->status }}</td>
            </tr>
            <tr>
                <th class="pl-2 py-1 w-1/4">{{ __('butik::cp.method') }}</th>
                <td>{{ $order->method }}</td>
            </tr>
            <tr>
                <th class="pl-2 py-1 w-1/4">{{ __('butik::cp.total_amount') }}</th>
                <td>{{ currency() }} {{ $order->total_amount }}</td>
            </tr>
            @if ($order->shipped_at)
                <tr>
                    <th class="pl-2 py-1 w-1/4">{{ __('butik::cp.shipped_at') }}</th>
                    <td>{{ $order->shipped_at }}</td>
                </tr>
            @endif
            @if ($order->paid_at)
                <tr>
                    <th class="pl-2 py-1 w-1/4">{{ __('butik::cp.paid_at') }}</th>
                    <td>{{ $order->paid_at }}</td>
                </tr>
            @elseif ($order->failed_at)
                <tr>
                    <th class="pl-2 py-1 w-1/4">{{ __('butik::cp.failed_at') }}</th>
                    <td>{{ $order->failed_at }}</td>
                </tr>
            @endif
            <tr>
                <th class="pl-2 py-1 w-1/4">{{ __('butik::cp.created_at') }}</th>
                <td>{{ $order->created_at }}</td>
            </tr>
        </table>
    </div>

    <h2 class="mt-4 mb-2 font-bold text-xl">{{ __('butik::cp.customer') }}</h2>
    <div class="card p-0">
        <table class="data-table">
            <tr>
                <th class="pl-2 py-1 w-1/4">{{ __('butik::cp.name') }}</th>
                <td>{{ $customer->firstname }} {{ $customer->surname }}</td>
            </tr>
            <tr>
                <th class="pl-2 py-1 w-1/4">{{ __('butik::cp.email') }}</th>
                <td>{{ $customer->email }}</td>
            </tr>
            <tr>
                <th class="pl-2 py-1 w-1/4">{{ __('butik::cp.address') }}</th>
                <td>
                    {{ $customer->address1 }} <br>
                    {{ $customer->address2 ??= $customer->address2 }}
                </td>
            </tr>
            <tr>
                <th class="pl-2 py-1 w-1/4">{{ __('butik::cp.zip') }} / {{ __('butik::cp.city') }}</th>
                <td>{{ $customer->zip }} {{ $customer->city }}</td>
            </tr>
            <tr>
                <th class="pl-2 py-1 w-1/4">{{ __('butik::cp.country_singular') }}</th>
                <td>{{ $customer->country }}</td>
            </tr>
             @foreach($additionalCustomerInformation as $information)
                <tr>
                    <th class="pl-2 py-1 w-1/4">{{ $information['name']  }}</th>
                    <td>{{ $information['value'] }}</td>
                </tr>
            @endforeach
        </table>
    </div>

    <h1 class="mt-3">{{ __('butik::cp.product_plural') }}</h1>

    @foreach ($items as $item)
        <h2 class="mt-4 font-bold text-xl">{{ $item->name }}</h2>
        <div class="card p-0">
            <table class="data-table">
                <tr>
                    <th class="pl-2 py-1 w-1/4">{{ __('butik::cp.single_price') }}</th>
                    <td>{{ $item->singlePrice }}</td>
                </tr>
                <tr>
                    <th class="pl-2 py-1 w-1/4">{{ __('butik::cp.quantity') }}</th>
                    <td>{{ $item->quantity }}</td>
                </tr>
                <tr>
                    <th class="pl-2 py-1 w-1/4">S{{ __('butik::cp.summed_price') }}</th>
                    <td>{{ $item->totalPrice }}</td>
                </tr>
                <tr>
                    <th class="pl-2 py-1 w-1/4">{{ __('butik::cp.tax_rate') }}</th>
                    <td>{{ $item->taxRate }}</td>
                </tr>
            </table>
        </div>
    @endforeach

    <span class="block text-2xs mt-4 mb-2">{{ __('butik::cp.all_informations_saved_from_buying_date') }}</span>
@endsection
