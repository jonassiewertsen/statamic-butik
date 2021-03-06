<?php

namespace Jonassiewertsen\Butik\Policies;

use Jonassiewertsen\Butik\Http\Models\Variant;

class VariantPolicy extends Policies
{
    public function index($user)
    {
        return $this->hasPermission($user, 'edit products entries');
    }

    public function create($user)
    {
        return $this->hasPermission($user, 'edit products entries');
    }

    public function store($user)
    {
        return $this->hasPermission($user, 'edit products entries');
    }

    public function edit($user, Variant $variant)
    {
        return $this->hasPermission($user, 'edit products entries');
    }

    public function update($user, $variant)
    {
        return $this->hasPermission($user, 'edit products entries');
    }

    public function delete($user, Variant $variant)
    {
        return $this->hasPermission($user, 'edit products entries');
    }
}
