<?php

namespace Jonassiewertsen\StatamicButik\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Statamic\Auth\User;
use Jonassiewertsen\StatamicButik\Http\Models\Tax;

class TaxPolicy
{
    use HandlesAuthorization;

    public function index(User $user, $ability)
    {
        return $user->hasPermission('view taxes');
    }

    public function create(User $user, $ability)
    {
        return $user->hasPermission('create taxes');
    }

    public function store($user, $ability)
    {
        return $user->hasPermission('create taxes');
    }

    public function edit($user, Tax $tax)
    {
        return $user->hasPermission('edit taxes');
    }

    public function update(User $user, Tax $tax)
    {
        return $user->hasPermission('update taxes');
    }

    public function delete(User $user, Tax $tax)
    {
        return $user->hasPermission('delete taxes');
    }

}