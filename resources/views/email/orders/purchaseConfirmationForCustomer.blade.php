@yield('title', __('butik::order.confirmation'))

@extends('butik::email.layout', [
    'heading'   => __('butik::order.confirmation'),
])

@section('content')

    <div style="text-align: center; padding-right: 12px; padding-top: 50px; font-weight: 600;">
        {{ __('butik::product.plural') }}
    </div>
    <div class="text" style="padding: 0 3em; margin: 40px 0; text-align: center;">
        @foreach ($items as $item)
            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="margin: 25px 0 !important;">
                <tr>
                    <td colspan="3" valign="top" width="100%" style="text-align: left; font-weight: 600; line-height: 1;">
                        {{ $item->name ?? '' }}
                    </td>
                </tr>
                @if (isset($item->description))
                    <tr>
                        <td colspan="3" valign="top" width="100%" style="text-align: left;">
                            {{ $item->description ?? '' }}
                        </td>
                    </tr>
                @endif
                <tr style="font-style: italic;">
                    <td valign="top" width="33%" style="text-align: left; font-size: 14px;">
                        <b>{{ $item->quantity ?? '' }}x</b> {{ $item->singlePrice ?? '' }}
                    </td>
                    <td valign="top" width="34%" style="text-align: left; font-size: 14px;">
                        Shipping included
                    </td>
                    <td valign="top" width="33%" style="text-align: right; font-weight: 600;">
                        {{ currency() ?? '' }} {{ $item->totalPrice ?? '' }}
                    </td>
                </tr>
            </table>
        @endforeach
    </div>

    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">

        <tr>
            <td valign="top" width="33%" style="text-align: right; padding-right: 12px; font-weight: 600;">
                {{ __('butik::product.total_amount') }}
            </td>
            <td valign="top" width="67%" style="text-align: left;">
                {{ currency() ?? '' }} {{ $totalAmount ?? '' }}
            </td>
        </tr>

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
                {{ __('butik::product.status') }}
            </td>
            <td valign="top" width="67%" style="text-align: left;">
                {{ __('butik::general.paid') }}
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
