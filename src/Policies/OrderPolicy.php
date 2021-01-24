<?php

namespace Jonassiewertsen\StatamicButik\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Statamic\Auth\User;

class OrderPolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return $user->hasPermission('view orders');
    }

    public function show(User $user, $order)
    {
        return $user->hasPermission('show orders');
    }

    public function update(User $user, $order)
    {
        return $user->hasPermission('update products');
    }
}
