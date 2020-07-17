<?php

namespace Jonassiewertsen\StatamicButik\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Statamic\Auth\User;
use Jonassiewertsen\StatamicButik\Http\Models\Country;

class CountryPolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return $user->hasPermission('view countries');
    }

    public function create(User $user)
    {
        return $user->hasPermission('create countries');
    }

    public function store(User $user)
    {
        return $user->hasPermission('create countries');
    }

    public function edit($user, Country $country)
    {
        return $user->hasPermission('edit countries');
    }

    public function update(User $user, $country)
    {
        return $user->hasPermission('edit countries');
    }

    public function delete(User $user, Country $country)
    {
        return $user->hasPermission('delete countries');
    }

}
