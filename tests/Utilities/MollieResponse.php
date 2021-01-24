<?php

namespace Jonassiewertsen\StatamicButik\Tests\Utilities;

use Mollie\Api\MollieApiClient;
use Mollie\Api\Resources\Capture;
use Mollie\Api\Resources\CaptureCollection;
use Mollie\Api\Resources\Chargeback;
use Mollie\Api\Resources\ChargebackCollection;
use Mollie\Api\Resources\Payment;
use Mollie\Api\Resources\Refund;
use Mollie\Api\Resources\RefundCollection;
use Mollie\Api\Resources\ResourceFactory;
use Mollie\Api\Types\PaymentStatus;
use Mollie\Api\Types\SequenceType;

abstract class MollieResponse
{
    public $profileId;
    public $sequenceType;
    public $redirectUrl;
    public $webhookUrl;
    public $mandateId;
    public $subscriptionId;
    public $orderId;
    public $settlementId;
    public $locale = 'en_US';
    public $metadata;
    public $details;
    public $_links;
    public $_embedded;
    public $isCancelable;

    public function isCanceled()
    {
        return $this->status === PaymentStatus::STATUS_CANCELED;
    }

    public function isExpired()
    {
        return $this->status === PaymentStatus::STATUS_EXPIRED;
    }

    public function isOpen()
    {
        return $this->status === PaymentStatus::STATUS_OPEN;
    }

    public function isPending()
    {
        return $this->status === PaymentStatus::STATUS_PENDING;
    }

    public function isAuthorized()
    {
        return $this->status === PaymentStatus::STATUS_AUTHORIZED;
    }

    public function isPaid()
    {
        return !empty($this->paidAt);
    }

    public function hasRefunds()
    {
        return !empty($this->_links->refunds);
    }

    public function hasChargebacks()
    {
        return !empty($this->_links->chargebacks);
    }

    public function isFailed()
    {
        return $this->status === PaymentStatus::STATUS_FAILED;
    }

    public function hasSequenceTypeFirst()
    {
        return $this->sequenceType === SequenceType::SEQUENCETYPE_FIRST;
    }

    public function hasSequenceTypeRecurring()
    {
        return $this->sequenceType === SequenceType::SEQUENCETYPE_RECURRING;
    }

    public function getCheckoutUrl()
    {
        if (empty($this->_links->checkout)) {
            return null;
        }

        return $this->_links->checkout->href;
    }

    public function canBeRefunded()
    {
        return $this->amountRemaining !== null;
    }

    public function canBePartiallyRefunded()
    {
        return $this->canBeRefunded();
    }

    public function getAmountRefunded()
    {
        if ($this->amountRefunded) {
            return (float) $this->amountRefunded->value;
        }

        return 0.0;
    }

    public function getAmountRemaining()
    {
        if ($this->amountRemaining) {
            return (float) $this->amountRemaining->value;
        }

        return 0.0;
    }

    public function refunds()
    {
        if (!isset($this->_links->refunds->href)) {
            return new RefundCollection($this->client, 0, null);
        }

        $result = $this->client->performHttpCallToFullUrl(
            MollieApiClient::HTTP_GET,
            $this->_links->refunds->href
        );

        return ResourceFactory::createCursorResourceCollection(
            $this->client,
            $result->_embedded->refunds,
            Refund::class,
            $result->_links
        );
    }

    public function getRefund($refundId, array $parameters = [])
    {
        return $this->client->paymentRefunds->getFor($this, $refundId, $parameters);
    }

    public function captures()
    {
        if (!isset($this->_links->captures->href)) {
            return new CaptureCollection($this->client, 0, null);
        }

        $result = $this->client->performHttpCallToFullUrl(
            MollieApiClient::HTTP_GET,
            $this->_links->captures->href
        );

        return ResourceFactory::createCursorResourceCollection(
            $this->client,
            $result->_embedded->captures,
            Capture::class,
            $result->_links
        );
    }

    public function getCapture($captureId, array $parameters = [])
    {
        return $this->client->paymentCaptures->getFor(
            $this,
            $captureId,
            $parameters
        );
    }

    public function chargebacks()
    {
        if (!isset($this->_links->chargebacks->href)) {
            return new ChargebackCollection($this->client, 0, null);
        }

        $result = $this->client->performHttpCallToFullUrl(
            MollieApiClient::HTTP_GET,
            $this->_links->chargebacks->href
        );

        return ResourceFactory::createCursorResourceCollection(
            $this->client,
            $result->_embedded->chargebacks,
            Chargeback::class,
            $result->_links
        );
    }

    public function getChargeback($chargebackId, array $parameters = [])
    {
        return $this->client->paymentChargebacks->getFor(
            $this,
            $chargebackId,
            $parameters
        );
    }

    public function refund($data = [])
    {
        $resource = 'payments/'.urlencode($this->id).'/refunds';

        $body = null;
        if (count($data) > 0) {
            $body = json_encode($data);
        }

        $result = $this->client->performHttpCall(
            MollieApiClient::HTTP_POST,
            $resource,
            $body
        );

        return ResourceFactory::createFromApiResult(
            $result,
            new Refund($this->client)
        );
    }

    public function update()
    {
        if (!isset($this->_links->self->href)) {
            return $this;
        }

        $body = json_encode([
            'description' => $this->description,
            'redirectUrl' => $this->redirectUrl,
            'webhookUrl'  => $this->webhookUrl,
            'metadata'    => $this->metadata,
        ]);

        $result = $this->client->performHttpCallToFullUrl(
            MollieApiClient::HTTP_PATCH,
            $this->_links->self->href,
            $body
        );

        return ResourceFactory::createFromApiResult($result, new Payment($this->client));
    }
}
