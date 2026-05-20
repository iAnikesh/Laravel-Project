<?php

namespace App\Policies;

use App\Models\HousingApplication;
use App\Models\User;

class HousingApplicationPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, HousingApplication $housingApplication): bool
    {
        return $user->isStaff() || $housingApplication->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, HousingApplication $housingApplication): bool
    {
        return $housingApplication->canBeEditedBy($user);
    }

    public function delete(User $user, HousingApplication $housingApplication): bool
    {
        return $user->isAdmin();
    }

    public function review(User $user, HousingApplication $housingApplication): bool
    {
        return $user->isStaff();
    }
}
