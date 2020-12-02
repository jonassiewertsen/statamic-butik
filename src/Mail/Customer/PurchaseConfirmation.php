<?php

namespace Jonassiewertsen\StatamicButik\Mail\Customer;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Jonassiewertsen\StatamicButik\Http\Models\Order;

class PurchaseConfirmation extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function build()
    {
        return $this->subject(__('butik::web.order_confirmation'))
            ->markdown('butik::email.orders.purchaseConfirmationForCustomer')
            ->with([
//                'customer'     => $this->order->customer,
                'items'        => $this->order->items,
                'order_id'     => $this->order->id,
                'paid_at'      => $this->order->paid_at,
                'total_amount' => $this->order->total_amount,
            ]);
    }
}
