<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers\Web;

use Jonassiewertsen\StatamicButik\Http\Controllers\WebController;

abstract class Checkout extends WebController
{
    protected function rules()
    {
        return [
            'country'      => 'required|max:50',
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
}
