<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'avatar',
        'bio',
        'student_id',
        'faculty',
        'major',
        'skills',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'SUPER_ADMIN';
    }

    public function isCampusAdmin(): bool
    {
        return $this->role === 'CAMPUS_ADMIN';
    }

    public function isSupervisor(): bool
    {
        return $this->role === 'SUPERVISOR';
    }

    public function isGroupLeader(): bool
    {
        return $this->role === 'GROUP_LEADER';
    }

    public function isStudent(): bool
    {
        return in_array($this->role, ['STUDENT', 'GROUP_LEADER']);
    }

    public function isVillageAdmin(): bool
    {
        return $this->role === 'VILLAGE_ADMIN';
    }

    public function isUmkmOwner(): bool
    {
        return $this->role === 'UMKM_OWNER';
    }

    public function hasRole(string|array $roles): bool
    {
        if (is_array($roles)) {
            return in_array($this->role, $roles);
        }
        return $this->role === $roles;
    }

    public function campusMemberships(): HasMany
    {
        return $this->hasMany(CampusMember::class);
    }

    public function groupMemberships(): HasMany
    {
        return $this->hasMany(GroupMember::class);
    }

    public function supervisedGroups(): HasMany
    {
        return $this->hasMany(KknGroup::class, 'supervisor_id');
    }

    public function leadGroups(): HasMany
    {
        return $this->hasMany(KknGroup::class, 'leader_id');
    }

    public function villageAdmins(): HasMany
    {
        return $this->hasMany(VillageAdmin::class);
    }

    public function assignedTasks(): HasMany
    {
        return $this->hasMany(ProgramTask::class, 'assignee_id');
    }

    public function systemNotifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }
}
