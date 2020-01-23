<?php

namespace Jonassiewertsen\StatamicButik\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Jonassiewertsen\StatamicButik\Http\Models\Order;
use Statamic\Auth\User;

class OrderPolicy
{
    use HandlesAuthorization;

    public function index(User $user, $ability)
    {
        return $user->hasPermission('view orders');
    }

    public function show(User $user, $ability)
    {
        return $user->hasPermission('show orders');
    }

    public function update(User $user, Order $product)
    {
        return $user->hasPermission('update products');
    }
}