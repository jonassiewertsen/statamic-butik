@extends('butik::email.layout', [
    'heading'   => __('butik::payment.successful'),
    'subheading' => 'Express Checkout',
])

@section('content')

    <div style="text-align: center; padding-right: 12px; padding-top: 20px; font-weight: 600;">
        {{ __('butik::product.plural') }}
    </div>
    <div class="text" style="padding: 0 3em; margin-bottom: 60px; text-align: center;">
        @foreach ($items as $item)
            <h2>{{ $item->name }}</h2>
        @endforeach
    </div>

    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td valign="top" width="33%" style="text-align: right; padding-right: 12px; font-weight: 600;">
                {{ __('butik::order.order_id') }}
            </td>
            <td valign="top" width="67%" style="text-align: left;">
                {{ $id }}
            </td>
        </tr>

        <tr>
            <td valign="top" width="33%" style="text-align: right; padding-right: 12px; font-weight: 600;">
                {{ __('butik::product.total_amount') }}
            </td>w
            <td valign="top" width="67%" style="text-align: left;">
                {{ currency() ?? '' }} {{ $totalAmount ?? '' }}
            </td>
        </tr>

        <tr>
            <td valign="top" width="33%" style="text-align: right; padding-right: 12px; font-weight: 600;">
                {{ __('butik::product.status') }}
            </td>
            <td valign="top" width="67%" style="text-align: left;">
                Paid
            </td>
        </tr>

        <tr>
            <td valign="top" width="33%" style="text-align: right; padding-right: 12px; font-weight: 600;">
                {{ __('butik::product.ordered_at') }}
            </td>
            <td valign="top" width="67%" style="text-align: left;">
                {{ $paidAt ?? '' }}
            </td>
        </tr>

        <br/>

    </table>

@endsection
