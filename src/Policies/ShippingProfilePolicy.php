<?php

namespace Jonassiewertsen\StatamicButik\Policies;

use Jonassiewertsen\StatamicButik\Http\Models\ShippingProfile;

class ShippingProfilePolicy extends Policies
{
    public function index($user)
    {
        return $this->hasPermission($user, 'view shippings');
    }

    public function show($user)
    {
        return $this->hasPermission($user, 'view shippings');
    }

    public function create($user)
    {
        return $this->hasPermission($user, 'create shippings');
    }

    public function store($user)
    {
        return $this->hasPermission($user, 'create shippings');
    }

    public function edit($user, ShippingProfile $shippingProfile)
    {
        return $this->hasPermission($user, 'edit shippings');
    }

    public function update($user, $shippingProfile)
    {
        return $this->hasPermission($user, 'edit shippings');
    }

    public function delete($user, ShippingProfile $shippingProfile)
    {
        return $this->hasPermission($user, 'delete shippings');
    }
}
