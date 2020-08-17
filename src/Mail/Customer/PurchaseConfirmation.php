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

    protected Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function build()
    {
        return $this->subject(__('butik::order.confirmation'))
            ->view('butik::email.orders.purchaseConfirmationForCustomer')
            ->with([
                'id'             => $this->order->id,
                'totalAmount'    => $this->order->totalAmount,
                'paidAt'         => $this->order->paidAt,
                'items'          => $this->order->items,
            ]);

    }
}
