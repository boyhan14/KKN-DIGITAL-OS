<?php

namespace App\Services;

use App\Models\User;
use App\Models\Campus;
use App\Models\Village;
use App\Models\KknGroup;

class TenantService
{
    /**
     * Get accessible campus for the user.
     */
    public function getUserCampus(User $user): ?Campus
    {
        if ($user->isSuperAdmin()) {
            return Campus::first();
        }

        $membership = $user->campusMemberships()->first();
        if ($membership) {
            return $membership->campus;
        }

        // Check if student or group leader in a group
        $groupMember = $user->groupMemberships()->with('kknGroup.kknProgram.campus')->first();
        if ($groupMember && $groupMember->kknGroup && $groupMember->kknGroup->kknProgram) {
            return $groupMember->kknGroup->kknProgram->campus;
        }

        // Check if supervisor
        $supervised = $user->supervisedGroups()->with('kknProgram.campus')->first();
        if ($supervised && $supervised->kknProgram) {
            return $supervised->kknProgram->campus;
        }

        return Campus::first();
    }

    /**
     * Get primary active KKN Group for the user.
     */
    public function getUserGroup(User $user): ?KknGroup
    {
        if ($user->isGroupLeader() || $user->isStudent()) {
            $membership = $user->groupMemberships()->with('kknGroup')->first();
            return $membership ? $membership->kknGroup : null;
        }

        if ($user->isSupervisor()) {
            return $user->supervisedGroups()->first();
        }

        if ($user->isSuperAdmin()) {
            return KknGroup::first();
        }

        return null;
    }

    /**
     * Get primary active Village for the user.
     */
    public function getUserVillage(User $user): ?Village
    {
        if ($user->isVillageAdmin()) {
            $admin = $user->villageAdmins()->with('village')->first();
            return $admin ? $admin->village : null;
        }

        $group = $this->getUserGroup($user);
        if ($group) {
            return $group->village;
        }

        return Village::first();
    }

    /**
     * Verify if user can write/modify operational content for the given group.
     * Only active student members of the group or SuperAdmin can write group proker/tasks.
     * Supervisors act as reviewers/evaluators and do not create student group content.
     */
    public function canWriteGroup(User $user, KknGroup $group): bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        if ($group->status === 'COMPLETED') {
            return false; // Operational write locked after handover!
        }

        return $group->members()->where('users.id', $user->id)->exists();
    }

    /**
     * Check if user can create work programs for the group.
     */
    public function canCreateProgram(User $user, KknGroup $group): bool
    {
        return $this->canWriteGroup($user, $group);
    }

    /**
     * Check if user can manage tasks (Kanban) for the group.
     */
    public function canManageTasks(User $user, KknGroup $group): bool
    {
        return $this->canWriteGroup($user, $group);
    }

    /**
     * Check if user can upload documents to the group repository.
     */
    public function canUploadDocuments(User $user, KknGroup $group): bool
    {
        return $this->canWriteGroup($user, $group);
    }

    /**
     * Check if user can manage impact metrics for the group.
     */
    public function canManageImpact(User $user, KknGroup $group): bool
    {
        return $this->canWriteGroup($user, $group);
    }

    /**
     * Check if user can manage group members (Leader, Campus Admin, SuperAdmin).
     */
    public function canManageGroupMembers(User $user, KknGroup $group): bool
    {
        if ($user->isSuperAdmin() || $user->isCampusAdmin()) {
            return true;
        }

        if ($group->status === 'COMPLETED') {
            return false;
        }

        return $user->id === $group->leader_id || $group->members()->where('users.id', $user->id)->wherePivot('role', 'LEADER')->exists();
    }

    /**
     * Verify if user can manage the given village content (Profile, Tourism, Events, News, Maps, Gallery).
     * Supervisors and UMKM owners are excluded.
     */
    public function canManageVillage(User $user, Village $village): bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        if ($user->isSupervisor() || $user->isUmkmOwner()) {
            return false;
        }

        if ($user->isCampusAdmin()) {
            return $user->campusMemberships()->where('campus_id', $village->campus_id)->exists();
        }

        if ($user->isVillageAdmin()) {
            return $village->admins()->where('users.id', $user->id)->wherePivot('is_active', true)->exists();
        }

        $activeGroup = $village->activeGroup();
        if ($activeGroup && !$village->isHandedOver()) {
            return $this->canWriteGroup($user, $activeGroup);
        }

        return false;
    }
}
