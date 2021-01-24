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
        return $this->subject(__('butik::web.order_confirmation'))
            ->markdown('butik::email.orders.purchaseConfirmationForCustomer')
            ->with([
                'order_id'     => $this->order->id,
                'total_amount' => $this->order->total_amount,
                'paid_at'      => $this->order->paid_at,
                'items'        => $this->order->items,
            ]);
    }
}
