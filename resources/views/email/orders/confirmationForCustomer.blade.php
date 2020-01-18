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
                23484
            </td>
        </tr>

        <tr>
            <td valign="top" width="33%" style="text-align: right; padding-right: 12px; font-weight: 600;">
                Total Amount
            </td>
            <td valign="top" width="67%" style="text-align: left;">
                20 €
            </td>
        </tr>

        <tr>
            <td valign="top" width="33%" style="text-align: right; padding-right: 12px; font-weight: 600;">
                Status
            </td>
            <td valign="top" width="67%" style="text-align: left;">
                Payed
            </td>
        </tr>

        <tr>
            <td valign="top" width="33%" style="text-align: right; padding-right: 12px; font-weight: 600;">
                Ordered at
            </td>
            <td valign="top" width="67%" style="text-align: left;">
                20. August 2020
            </td>
        </tr>

    </table>

@endsection