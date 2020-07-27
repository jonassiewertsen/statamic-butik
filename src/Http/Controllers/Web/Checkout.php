<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers\Web;

use Jonassiewertsen\StatamicButik\Http\Controllers\WebController;
use Statamic\View\View as StatamicView;

abstract class Checkout extends WebController
{
    protected function rules()
    {
        return [
            'country'      => ['required', function ($attribute, $value, $fail) {
                if (! Countries::exists($value)) {
                    $fail('Invalid country code: ' . $value);
                }
            }],
            'name'         => 'required|min:5|max:50',
            'mail'         => 'required|email',
            'address1'     => 'required|max:80',
            'address2'     => 'nullable|max:80',
            'city'         => 'required|max:80',
            'state_region' => 'nullable|max:80',
            'zip'          => 'required|max:20',
            'phone'        => 'nullable|max:50',
        ];
    }

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
            if (!session()->has("butik.transaction.{$key}")) {
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
