<?php

namespace Jonassiewertsen\StatamicButik\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingZone;
use Statamic\Auth\User;

class ShippingZonePolicy
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

    public function edit($user, ShippingZone $shippingZone)
    {
        return $user->hasPermission('edit shippings');
    }

    public function update(User $user, $shippingZone)
    {
        return $user->hasPermission('edit shippings');
    }

    public function delete(User $user, ShippingZone $shippingZone)
    {
        return $user->hasPermission('delete shippings');
    }
}
