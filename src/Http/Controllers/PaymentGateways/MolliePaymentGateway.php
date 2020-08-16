<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers\PaymentGateways;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Jonassiewertsen\StatamicButik\Checkout\Customer;
use Jonassiewertsen\StatamicButik\Events\OrderCreated;
use Jonassiewertsen\StatamicButik\Http\Models\Order;
use Jonassiewertsen\StatamicButik\Http\Traits\MollyLocale;
use Jonassiewertsen\StatamicButik\Http\Traits\MoneyTrait;
use Jonassiewertsen\StatamicButik\Order\ItemCollection;
use Mollie\Laravel\Facades\Mollie;

class MolliePaymentGateway extends PaymentGateway implements PaymentGatewayInterface
{
    use MollyLocale;
    use MoneyTrait;

    public function handle(Customer $customer, Collection $items, string $totalPrice)
    {
        $payment = Mollie::api()->orders()->create(
            $this->createMollieOrderData($customer, $items, $totalPrice)
        );

        $order = $this->createOrder($customer, $items, $totalPrice, $payment);
        event(new OrderCreated($order));

        // redirect customer to Mollie checkout page
        return redirect($payment->getCheckoutUrl(), 303);
    }

    public function webhook(Request $request)
    {
        if (!$request->has('id')) {
            return;
        }

        $payment = Mollie::api()->orders()->get($request->id);

        switch ($payment->status) {
            case 'paid':
                $this->isPaid($payment);
                break;
            case 'authorized':
                $this->isAuthorized($payment);
                break;
            case 'completed':
                $this->isCompleted($payment);
                break;
            case 'expired':
                $this->isExpired($payment);
                break;
            case 'canceled':
                $this->isCanceled($payment);
                break;
        }
    }

    private function createOrder($customer, $items, $totalPrice, $payment): Order
    {
        $order               = new Order();
        $order->id           = $payment->id;
        $order->number       = now()->format('Ymd_') . str_random(30);
        $order->status       = 'open';
        $order->method       = $payment->method;
        $order->customer     = $customer;
        $order->total_amount = $totalPrice;
        $order->items        = new ItemCollection($items);
        $order->save();

        return $order;
    }

    private function createMollieOrderData($customer, $items, $totalPrice)
    {
        $orderData = [
            'amount' => [
                'currency' => config('butik.currency_isoCode'),
                'value'    => $totalPrice,
            ],
            'billingAddress' => [
                'givenName'       => $customer->name,
                'familyName'      => $customer->name,
                'streetAndNumber' => $customer->address1 . ', ' . $customer->address2,
                'city'            => $customer->city,
                'postalCode'      => $customer->zip,
                'country'         => $customer->country,
                'email'           => $customer->mail,
            ],
            'orderNumber' => $orderId = now()->format('Ymd_') . str_random(30),
            'locale'      => $this->getLocale(),
            'webhookUrl' => env('MOLLIE_NGROK_REDIRECT') . route('butik.payment.webhook.mollie', [], false),
            'redirectUrl' => URL::temporarySignedRoute('butik.payment.receipt', now()->addMinutes(5), ['order' => $orderId]),
            'lines'       => $this->mapItems($items),
        ];

        if (!App::environment(['local'])) {
            // Only adding the mollie webhook, when not in local environment
            $orderData = array_merge($orderData, [
                'webhookUrl' => route('butik.payment.webhook.mollie'),
            ]);
        } elseif (App::environment(['local']) && $this->ngrokSet()) {
            // When local env and the the NGROK has been set, it will add the ngrok url
            $route = env('MOLLIE_NGROK_REDIRECT') . route('butik.payment.webhook.mollie', [], false);

            $orderData = array_merge($orderData, [
                'webhookUrl' => $route,
            ]);
        }

        return $orderData;
    }

    private function mapItems($items)
    {
        return $items->map(function($item) {
            return [
                'type'           => 'physical',
                'sku'            => $item->slug,
                'name'           => $item->name,
                'imageUrl'       => $this->images[0] ?? null,
                'quantity'       => $item->getQuantity(),
                'vatRate'        => (string) number_format($item->taxRate, 2),
                'unitPrice'      => [
                    'currency' => config('butik.currency_isoCode'),
                    'value'    => $this->humanPriceWithDot($item->singlePrice()),
                ],
                'totalAmount'    => [
                    'currency' => config('butik.currency_isoCode'),
                    'value'    => $this->humanPriceWithDot($item->totalPrice()),
                ],
                'vatAmount'      => [
                    'currency' => config('butik.currency_isoCode'),
                    'value'    => $this->humanPriceWithDot($item->taxAmount),
                ]
            ];
        })->toArray();
    }

    private function ngrokSet(): bool
    {
        return env('MOLLIE_NGROK_REDIRECT', false) == true;
    }
}
