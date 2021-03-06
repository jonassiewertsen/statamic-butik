<?php

namespace Jonassiewertsen\Butik\Policies;

use Statamic\Facades\User;

abstract class Policies
{
    protected function hasPermission($user, string $permission)
    {
        $user = User::fromUser($user);

        return $user->hasPermission($permission);
    }
}
