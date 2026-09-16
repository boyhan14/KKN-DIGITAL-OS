<?php

namespace App\Policies;

use App\Models\User;
use App\Models\KknGroup;

class KknGroupPolicy
{
    public function view(User $user, KknGroup $group): bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        if ($user->isCampusAdmin()) {
            return $user->campusMemberships()->where('campus_id', $group->kknProgram->campus_id)->exists();
        }

        if ($user->isSupervisor() && $group->supervisor_id === $user->id) {
            return true;
        }

        if ($user->isVillageAdmin() && $group->village->admins()->where('users.id', $user->id)->exists()) {
            return true;
        }

        return $group->members()->where('users.id', $user->id)->exists();
    }

    public function update(User $user, KknGroup $group): bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        // Operational write locked after handover completion
        if ($group->status === 'COMPLETED') {
            return false;
        }

        if ($user->isCampusAdmin()) {
            return $user->campusMemberships()->where('campus_id', $group->kknProgram->campus_id)->exists();
        }

        if ($user->isSupervisor() && $group->supervisor_id === $user->id) {
            return true;
        }

        return $group->members()->where('users.id', $user->id)->exists();
    }
}
