<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers\CP;

use Jonassiewertsen\StatamicButik\Http\Controllers\CpController;

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
