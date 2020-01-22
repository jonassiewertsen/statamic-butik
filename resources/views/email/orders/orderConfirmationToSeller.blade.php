@extends('statamic-butik::email.layout', [
    'heading'   => 'Payment Successful ',
    'subheading' => 'Express Checkout',
])

@section('content')

    <div style="text-align: center; padding-right: 12px; font-weight: 600;">
        Prodcuts
    </div>
    <div class="text" style="padding: 0 3em; text-align: center;">
        @foreach ($transaction->products as $product)
            <h2>{{ $product->title }}</h2>
        @endforeach
    </div>

    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td valign="top" width="33%" style="text-align: right; padding-right: 12px; font-weight: 600;">
                Order ID
            </td>
            <td valign="top" width="67%" style="text-align: left;">
                {{ $transaction->id ?? '' }}
            </td>
        </tr>

        <tr>
            <td valign="top" width="33%" style="text-align: right; padding-right: 12px; font-weight: 600;">
                Total Amount
            </td>
            <td valign="top" width="67%" style="text-align: left;">
                {{ $transaction->totalAmount ?? '' }} {{ $transaction->currencySymbol ?? '' }}
            </td>
        </tr>

        <tr>
            <td valign="top" width="33%" style="text-align: right; padding-right: 12px; font-weight: 600;">
                Status
            </td>
            <td valign="top" width="67%" style="text-align: left;">
                Paid
            </td>
        </tr>

        <tr>
            <td valign="top" width="33%" style="text-align: right; padding-right: 12px; font-weight: 600;">
                Paid at
            </td>
            <td valign="top" width="67%" style="text-align: left;">
                {{ $transaction->paidAt ?? '' }}
            </td>
        </tr>

    </table>

@endsection