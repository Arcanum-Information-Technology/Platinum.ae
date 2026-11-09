<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;

class CategoryPolicy
{
    public function before(User $user, string $ability): ?bool
    {
        if ($user->hasRole('Super Admin')) {
            return true;
        }

        return null;
    }

    public function viewAny(User $user): bool
    {
        return $user->can('menu.view');
    }

    public function view(User $user, Category $category): bool
    {
        return $user->can('menu.view');
    }

    public function create(User $user): bool
    {
        return $user->can('menu.create');
    }

    public function update(User $user, Category $category): bool
    {
        return $user->can('menu.update');
    }

    public function delete(User $user, Category $category): bool
    {
        return $user->can('menu.delete');
    }
}
