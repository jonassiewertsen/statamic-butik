<?php

namespace Jonassiewertsen\Butik\Policies;

use Jonassiewertsen\Butik\Http\Models\ShippingRate;

class ShippingRatePolicy extends Policies
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

    public function edit($user, ShippingRate $shippingRate)
    {
        return $this->hasPermission($user, 'edit shippings');
    }

    public function update($user, $shippingRate)
    {
        return $this->hasPermission($user, 'edit shippings');
    }

    public function delete($user, ShippingRate $shippingRate)
    {
        return $this->hasPermission($user, 'delete shippings');
    }
}
