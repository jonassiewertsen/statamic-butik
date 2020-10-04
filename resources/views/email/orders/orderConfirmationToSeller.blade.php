@component('mail::message')
# {{ __('butik::web.order_confirmation') }}

@component('mail::table')
| Product        | Quantity       | Total    |
| :------------- | :------------- | --------:|
@foreach ($items as $item)
| {{ $item->name ?? '' }} | {{ $item->quantity ?? '' }} | {{ currency() }} {{ $item->totalPrice ?? '' }} |
@endforeach
@endcomponent

@component('mail::panel')
**Total Amount:** {{ currency() }} {{ $total_amount ?? '' }}

**Paid at:** {{ $paid_at ?? '' }}

**Order ID:** {{ $order_id ?? '' }}
@endcomponent

@endcomponent
