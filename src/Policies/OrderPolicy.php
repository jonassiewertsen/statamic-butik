<?php

namespace Jonassiewertsen\StatamicButik\Policies;

class OrderPolicy extends Policies
{
    public function index($user)
    {
        return $this->hasPermission($user, 'view orders');
    }

    public function show($user, $order)
    {
        return $this->hasPermission($user, 'show orders');
    }

    public function update($user, $order)
    {
        return $this->hasPermission($user, 'update products');
    }
}
