<?php

namespace Jonassiewertsen\StatamicButik\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Jonassiewertsen\StatamicButik\Http\Models\Variant;
use Statamic\Auth\User;

class VariantPolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return $user->hasPermission('edit products entries');
    }

    public function create(User $user)
    {
        return $user->hasPermission('edit products entries');
    }

    public function store(User $user)
    {
        return $user->hasPermission('edit products entries');
    }

    public function edit($user, Variant $variant)
    {
        return $user->hasPermission('edit products entries');
    }

    public function update(User $user, $variant)
    {
        return $user->hasPermission('edit products entries');
    }

    public function delete(User $user, Variant $variant)
    {
        return $user->hasPermission('edit products entries');
    }
}
