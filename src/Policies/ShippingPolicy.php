<?php

namespace Jonassiewertsen\StatamicButik\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Statamic\Auth\User;
use Jonassiewertsen\StatamicButik\Http\Models\Shipping;

class ShippingPolicy
{
    use HandlesAuthorization;

    public function index(User $user, $ability)
    {
        return $user->hasPermission('view shippings');
    }

    public function create(User $user, $ability)
    {
        return $user->hasPermission('create shippings');
    }

    public function store($user, $ability)
    {
        return $user->hasPermission('create shippings');
    }

    public function edit($user, Shipping $shipping)
    {
        return $user->hasPermission('edit shippings');
    }

    public function update(User $user, Shipping $shipping)
    {
        return $user->hasPermission('update shippings');
    }

    public function delete(User $user, Shipping $shipping)
    {
        return $user->hasPermission('delete shippings');
    }

}