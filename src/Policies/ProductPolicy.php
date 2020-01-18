<?php

namespace Jonassiewertsen\StatamicButik\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Statamic\Auth\User;
use Jonassiewertsen\StatamicButik\Http\Models\Product;

class ProductPolicy
{
    use HandlesAuthorization;

    public function view(User $user) {
        return $user->hasPermission('view products');
    }

}