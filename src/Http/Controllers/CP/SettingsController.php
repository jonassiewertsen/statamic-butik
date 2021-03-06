<?php

namespace Jonassiewertsen\Butik\Http\Controllers\CP;

use Jonassiewertsen\Butik\Http\Controllers\CpController;

class SettingsController extends CpController
{
    public function index()
    {
        if (! $this->isUserAuthorized()) {
            return abort(403);
        }

        return view('butik::cp.settings.index');
    }

    private function isUserAuthorized()
    {
        return auth()->user()->can('view shippings') || auth()->user()->can('view taxes');
    }
}
