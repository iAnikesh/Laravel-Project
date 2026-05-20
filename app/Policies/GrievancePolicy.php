<?php

namespace App\Policies;

use App\Models\Grievance;
use App\Models\User;

class GrievancePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Grievance $grievance): bool
    {
        return $user->isStaff() || $grievance->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Grievance $grievance): bool
    {
        return $user->isStaff() || $grievance->user_id === $user->id;
    }

    public function respond(User $user, Grievance $grievance): bool
    {
        return $user->isStaff();
    }
}
