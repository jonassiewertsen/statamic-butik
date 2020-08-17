<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers\PaymentGateways;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Jonassiewertsen\StatamicButik\Checkout\Customer;
use Jonassiewertsen\StatamicButik\Http\Traits\MollyLocale;
use Jonassiewertsen\StatamicButik\Http\Traits\MoneyTrait;
use Mollie\Laravel\Facades\Mollie;

class MolliePaymentGateway extends PaymentGateway implements PaymentGatewayInterface
{
    use MollyLocale;
    use MoneyTrait;

    /**
     * We want to handle the payment process.
     *
     * We will create the Mollie Order, save those information into our
     * database and will redirect for the payment itself to the Mollie checkout.
     */
    public function handle(Customer $customer, Collection $items, string $totalPrice)
    {
        $payment = Mollie::api()->orders()->create(
            $this->createMollieOrderData($customer, $items, $totalPrice)
        );

        $this->createOrder(
            $payment->id,
            $items,
            $customer,
            $totalPrice,
            $payment->method
        );

        // redirect customer to Mollie checkout page
        return redirect($payment->getCheckoutUrl(), 303);
    }

    /**
     * To keep up to date with the actual payment status, we will listen for webook events fired
     * by Mollie.
     *
     * Regarding to those webhooks, we will update our orders.
     */
    public function webhook(Request $request): void
    {
        if (!$request->has('id')) {
            return;
        }

        $payment = Mollie::api()->orders()->get($request->id);
        $order   = $this->findOrder($payment->id);

        switch ($payment->status) {
            case 'paid':
                $this->isPaid($order);
                break;
            case 'authorized':
                $this->isAuthorized($order);
                break;
            case 'completed':
                $this->isCompleted($order);
                break;
            case 'expired':
                $this->isExpired($order);
                break;
            case 'canceled':
                $this->isCanceled($order);
                break;
        }
    }

    /**
     * Preparing the payment informations, as described in the Mollie documentation:
     *
     * https://docs.mollie.com/reference/v2/orders-api/create-order#example
     */
    private function createMollieOrderData($customer, $items, $totalPrice): array
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

    /**
     * The line items to need to be send in a specific format.
     *
     * https://docs.mollie.com/reference/v2/orders-api/create-order#order-lines-details
     */
    private function mapItems($items): array
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

    /**
     * Has a ngrook tunnel be set for local development?
     */
    private function ngrokSet(): bool
    {
        return env('MOLLIE_NGROK_REDIRECT', false) == true;
    }
}
