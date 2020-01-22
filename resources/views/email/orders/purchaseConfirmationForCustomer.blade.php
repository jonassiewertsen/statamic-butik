@extends('statamic-butik::email.layout', [
    'heading'   => 'Order confirmation',
    'subheading' => 'Express Checkout',
])

@section('content')

    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td valign="top" width="33%" style="text-align: right; padding-right: 12px; font-weight: 600;">
                Order ID
            </td>
            <td valign="top" width="67%" style="text-align: left;">
                {{ $transaction['id'] }}
            </td>
        </tr>

        <tr>
            <td valign="top" width="33%" style="text-align: right; padding-right: 12px; font-weight: 600;">
                Total Amount
            </td>
            <td valign="top" width="67%" style="text-align: left;">
                {{ $transaction['amount'] }} {{ $transaction['currency'] }}
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
                Ordered at
            </td>
            <td valign="top" width="67%" style="text-align: left;">
                {{ $transaction['created_at'] }}
            </td>
        </tr>

    </table>

@endsection