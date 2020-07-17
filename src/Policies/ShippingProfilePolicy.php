<?php

namespace Jonassiewertsen\StatamicButik\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Statamic\Auth\User;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingProfile;

class ShippingProfilePolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return $user->hasPermission('view shippings');
    }

    public function show(User $user)
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

    public function edit($user, ShippingProfile $shippingProfile)
    {
        return $user->hasPermission('edit shippings');
    }

    public function update(User $user, $shippingProfile)
    {
        return $user->hasPermission('edit shippings');
    }

    public function delete(User $user, ShippingProfile $shippingProfile)
    {
        return $user->hasPermission('delete shippings');
    }

}
