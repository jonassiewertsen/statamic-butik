<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers\CP;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Jonassiewertsen\StatamicButik\Blueprints\ProductBlueprint;
use Jonassiewertsen\StatamicButik\Http\Controllers\CpController;
use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Statamic\CP\Column;

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
