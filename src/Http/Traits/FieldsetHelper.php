<?php

namespace Jonassiewertsen\StatamicButik\Http\Traits;

use Statamic\Support\Str;

trait FieldsetHelper {
    /**
     * We will check in the requested routes, if we are calling a create route.
     */
    protected function isCreateRoute(): bool
    {
        return Str::of(request()->route()->action['uses'])->after('@') == 'create';
    }
}
