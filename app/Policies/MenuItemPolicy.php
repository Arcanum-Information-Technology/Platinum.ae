<?php

namespace App\Policies;

use App\Models\MenuItem;
use App\Models\User;

class MenuItemPolicy
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

    public function view(User $user, MenuItem $item): bool
    {
        return $user->can('menu.view');
    }

    public function create(User $user): bool
    {
        return $user->can('menu.create');
    }

    public function update(User $user, MenuItem $item): bool
    {
        return $user->can('menu.update');
    }

    public function delete(User $user, MenuItem $item): bool
    {
        return $user->can('menu.delete');
    }
}
