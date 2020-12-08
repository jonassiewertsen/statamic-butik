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
        $this->items = $order->items;
        $this->paid_at = $order->paid_at;
        $this->order_id = $order->id;
        $this->customer = $order->customer;
        $this->total_amount = $order->total_amount;
    }

    public function build()
    {
        return $this->subject(__('butik::web.order_confirmation'))
            ->markdown('butik::email.orders.purchaseConfirmationForCustomer');
    }
}
