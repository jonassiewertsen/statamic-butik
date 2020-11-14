<?php

namespace Jonassiewertsen\StatamicButik\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingRate;
use Statamic\Auth\User;

class ShippingRatePolicy
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

    public function store(User $user)
    {
        return $user->hasPermission('create shippings');
    }

    public function edit($user, ShippingRate $shippingRate)
    {
        return $user->hasPermission('edit shippings');
    }

    public function update(User $user, $shippingRate)
    {
        return $user->hasPermission('edit shippings');
    }

    public function delete(User $user, ShippingRate $shippingRate)
    {
        return $user->hasPermission('delete shippings');
    }
}
