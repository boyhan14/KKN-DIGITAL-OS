<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Village;

class VillagePolicy
{
    public function view(User $user, Village $village): bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        if ($user->isCampusAdmin()) {
            return $user->campusMemberships()->where('campus_id', $village->campus_id)->exists();
        }

        if ($user->isVillageAdmin()) {
            return $village->admins()->where('users.id', $user->id)->wherePivot('is_active', true)->exists();
        }

        // Supervisor or Student assigned to a group in this village
        $activeGroup = $village->activeGroup();
        if ($activeGroup) {
            if ($user->isSupervisor() && $activeGroup->supervisor_id === $user->id) {
                return true;
            }
            return $activeGroup->members()->where('users.id', $user->id)->exists();
        }

        return false;
    }

    public function manage(User $user, Village $village): bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        if ($user->isCampusAdmin()) {
            return $user->campusMemberships()->where('campus_id', $village->campus_id)->exists();
        }

        // If handed over, Village Admin has primary operational ownership
        if ($user->isVillageAdmin()) {
            return $village->admins()->where('users.id', $user->id)->wherePivot('is_active', true)->exists();
        }

        // Before handover, group members can manage content if group is ACTIVE
        $activeGroup = $village->activeGroup();
        if ($activeGroup && $activeGroup->status === 'ACTIVE') {
            if ($user->isSupervisor() && $activeGroup->supervisor_id === $user->id) {
                return true;
            }
            return $activeGroup->members()->where('users.id', $user->id)->exists();
        }

        return false;
    }
}
