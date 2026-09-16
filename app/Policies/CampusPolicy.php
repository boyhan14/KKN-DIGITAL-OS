<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Campus;

class CampusPolicy
{
    public function view(User $user, Campus $campus): bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        return $user->campusMemberships()->where('campus_id', $campus->id)->exists();
    }

    public function manage(User $user, Campus $campus): bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        return $user->isCampusAdmin() && $user->campusMemberships()->where('campus_id', $campus->id)->exists();
    }
}
