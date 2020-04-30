<?php

namespace Jonassiewertsen\StatamicButik\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Statamic\Auth\User;
use Jonassiewertsen\StatamicButik\Http\Models\Shipping;

class ShippingPolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return $user->hasPermission('view shippings');
    }

    public function create(User $user)
    {
        return $user->hasPermission('create shippings');
    }

    public function store($user)
    {
        return $user->hasPermission('create shippings');
    }

    public function edit($user, $shipping)
    {
        return $user->hasPermission('edit shippings');
    }

    public function update(User $user, $shipping)
    {
        return $user->hasPermission('edit shippings');
    }

    public function delete(User $user, $shipping)
    {
        return $user->hasPermission('delete shippings');
    }

}