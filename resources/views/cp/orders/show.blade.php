@extends('statamic::layout')
@section('title', 'Test')

@section('content')
    <h2 class="mt-4 mb-2 font-bold text-xl">{{ __('butik::order.singular') }}</h2>
    <div class="card p-0">
        <table class="data-table">
            <tr>
                <th class="pl-2 py-1 w-1/4">{{ __('butik::order.id') }}</th>
                <td>{{ $order->id }}</td>
            </tr>
            <tr>
                <th class="pl-2 py-1 w-1/4">Status</th>
                <td>{{ $order->status }}</td>
            </tr>
            <tr>
                <th class="pl-2 py-1 w-1/4">Method</th>
                <td>{{ $order->method }}</td>
            </tr>
            <tr>
                <th class="pl-2 py-1 w-1/4">Total Amount</th>
                <td>{{ config('butik.currency_symbol', '') }} {{ $order->total_amount }}</td>
            </tr>
            @if ($order->shipped_at)
                <tr>
                    <th class="pl-2 py-1 w-1/4">Shipped at</th>
                    <td>{{ $order->shipped_at }}</td>
                </tr>
            @endif
            @if ($order->paid_at)
                <tr>
                    <th class="pl-2 py-1 w-1/4">Paid at</th>
                    <td>{{ $order->paid_at }}</td>
                </tr>
            @elseif ($order->failed_at)
                <tr>
                    <th class="pl-2 py-1 w-1/4">Faild at</th>
                    <td>{{ $order->failed_at }}</td>
                </tr>
            @endif
            <tr>
                <th class="pl-2 py-1 w-1/4">Created</th>
                <td>{{ $order->created_at }}</td>
            </tr>
        </table>
    </div>

    <h2 class="mt-4 mb-2 font-bold text-xl">Customer</h2>
    <div class="card p-0">
        <table class="data-table">
            <tr>
                <th class="pl-2 py-1 w-1/4">Name</th>
                <td>{{ $customer->name }}</td>
            </tr>
            <tr>
                <th class="pl-2 py-1 w-1/4">Mail</th>
                <td>{{ $customer->mail }}</td>
            </tr>
            <tr>
                <th class="pl-2 py-1 w-1/4">Address</th>
                <td>
                    {{ $customer->address1 }} <br>
                    {{ $customer->address2 ??= $customer->address2 }}
                </td>
            </tr>
            <tr>
                <th class="pl-2 py-1 w-1/4">Zip / City</th>
                <td>{{ $customer->zip }} {{ $customer->city }}</td>
            </tr>
            <tr>
                <th class="pl-2 py-1 w-1/4">Country</th>
                <td>{{ $customer->country }}</td>
            </tr>
        </table>
    </div>

    <h1 class="mt-3">Products</h1>

    @foreach ($items as $item)
        <h2 class="mt-4 font-bold text-xl">{{ $item['name'] }}</h2>
        <span class="block text-2xs mb-2">All Informations saved from buying date</span>
        <div class="card p-0">
            <table class="data-table">
                <tr>
                    <th class="pl-2 py-1 w-1/4">Base price</th>

                    <td>{{ $item['product']['total_price'] }}</td>
                </tr>
            </table>
        </div>
    @endforeach
@endsection
