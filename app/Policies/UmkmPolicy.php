<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Umkm;

class UmkmPolicy
{
    public function update(User $user, Umkm $umkm): bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        // UMKM Owner can edit their own UMKM
        if ($umkm->user_id && $umkm->user_id === $user->id) {
            return true;
        }

        // Village Admin can manage if assigned to this village
        if ($user->isVillageAdmin() && $umkm->village->admins()->where('users.id', $user->id)->exists()) {
            return true;
        }

        // KKN group members can edit only if group is ACTIVE
        if ($umkm->kknGroup) {
            if ($umkm->kknGroup->status === 'COMPLETED') {
                return false;
            }
            return $umkm->kknGroup->members()->where('users.id', $user->id)->exists();
        }

        return false;
    }
}
