<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers\CP;

use Jonassiewertsen\StatamicButik\Http\Controllers\CpController;

class SettingsController extends CpController
{
    public function index()
    {
        return view('butik::cp.settings.index');
    }
}
