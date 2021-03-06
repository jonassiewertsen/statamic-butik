<?php

namespace Jonassiewertsen\Butik\Http\Controllers\Web;

use Jonassiewertsen\Butik\Http\Controllers\WebController;
use Statamic\View\View as StatamicView;

abstract class Checkout extends WebController
{
    protected function transactionDataComplete()
    {
        $keys = [
            'success',
            'id',
            'type',
            'currencyIsoCode',
            'amount',
            'created_at',
            'customer',
        ];
        foreach ($keys as $key) {
            if (! session()->has("butik.transaction.{$key}")) {
                return false;
            }
        }

        return true;
    }

    protected function transactionSuccessful()
    {
        return session()->has('butik.transaction.success')
            && session()->get('butik.transaction.success') === true;
    }

    protected function showInvalidReceipt()
    {
        return (new StatamicView())
            ->template(config('butik.template_checkout-receipt-invalid'))
            ->layout(config('butik.layout_checkout-receipt-invalid'));
    }
}
