<?php

namespace Jonassiewertsen\Butik\Policies;

use Jonassiewertsen\Butik\Http\Models\ShippingZone;

class ShippingZonePolicy extends Policies
{
    public function index($user)
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

    public function edit($user, ShippingZone $shippingZone)
    {
        return $this->hasPermission($user, 'edit shippings');
    }

    public function update($user, $shippingZone)
    {
        return $this->hasPermission($user, 'edit shippings');
    }

    public function delete($user, ShippingZone $shippingZone)
    {
        return $this->hasPermission($user, 'delete shippings');
    }
}
