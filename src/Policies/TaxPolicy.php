<?php

namespace Jonassiewertsen\StatamicButik\Policies;

use Jonassiewertsen\StatamicButik\Http\Models\Tax;

class TaxPolicy extends Policies
{
    public function index($user)
    {
        return $this->hasPermission($user, 'view taxes');
    }

    public function create($user)
    {
        return $this->hasPermission($user, 'create taxes');
    }

    public function store($user)
    {
        return $this->hasPermission($user, 'create taxes');
    }

    public function edit($user, Tax $tax)
    {
        return $this->hasPermission($user, 'edit taxes');
    }

    public function update($user, Tax $tax)
    {
        return $this->hasPermission($user, 'edit taxes');
    }

    public function delete($user, Tax $tax)
    {
        return $this->hasPermission($user, 'delete taxes');
    }
}
