<?php

namespace Jonassiewertsen\StatamicButik\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Statamic\Auth\User;
use Jonassiewertsen\StatamicButik\Http\Models\Product;

class ProductPolicy
{
    use HandlesAuthorization;

    public function index(User $user, $ability)
    {
        return $user->hasPermission('view products');
    }

    public function create(User $user, $ability)
    {
        return $user->hasPermission('create products');
    }

    public function store($user, $ability)
    {
        return $user->hasPermission('create products');
    }

    public function edit($user, Product $product)
    {
        return $user->hasPermission('edit products');
    }

    public function update(User $user, Product $product)
    {
        return $user->hasPermission('update products');
    }

    public function delete(User $user, Product $product)
    {
        return $user->hasPermission('delete products');
    }

}