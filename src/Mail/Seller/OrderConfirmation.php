<?php

namespace Jonassiewertsen\StatamicButik\Mail\Seller;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Jonassiewertsen\StatamicButik\Http\Models\Order;

class OrderConfirmation extends Mailable implements ShouldQueue
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
        return $this->subject(__('butik::order.new_purchase'))
            ->view('butik::email.orders.orderConfirmationToSeller')
            ->with([
               'id'             => $this->order->id,
               'totalAmount'    => $this->order->total_amount,
               'paidAt'         => $this->order->paid_at,
               'items'          => $this->order->items,
           ]);
    }
}
