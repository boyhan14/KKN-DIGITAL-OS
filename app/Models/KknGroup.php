<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class KknGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'kkn_program_id',
        'village_id',
        'supervisor_id',
        'leader_id',
        'group_name',
        'group_code',
        'start_date',
        'end_date',
        'status',
    ];

    public function getNameAttribute(): string
    {
        return $this->group_name;
    }

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    public function kknProgram(): BelongsTo
    {
        return $this->belongsTo(KknProgram::class);
    }

    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }

    public function supervisor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    public function leader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'leader_id');
    }

    public function memberPivot(): HasMany
    {
        return $this->hasMany(GroupMember::class);
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'group_members')
            ->withPivot('role', 'contribution_notes')
            ->withTimestamps();
    }

    public function programs(): HasMany
    {
        return $this->hasMany(Program::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(ProgramTask::class);
    }

    public function umkms(): HasMany
    {
        return $this->hasMany(Umkm::class);
    }

    public function tourismPlaces(): HasMany
    {
        return $this->hasMany(TourismPlace::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    public function albums(): HasMany
    {
        return $this->hasMany(Album::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(ProgramDocument::class);
    }

    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function impactMetrics(): HasMany
    {
        return $this->hasMany(ImpactMetric::class);
    }

    public function handoverPackages(): HasMany
    {
        return $this->hasMany(HandoverPackage::class);
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }

    public function progressPercentage(): int
    {
        $totalPrograms = $this->programs()->count();
        if ($totalPrograms === 0) {
            return 10; // Baseline initialized
        }

        $completedPrograms = $this->programs()->where('status', 'COMPLETED')->count();
        $tasksCount = $this->tasks()->count();
        $doneTasks = $this->tasks()->where('status', 'DONE')->count();

        $progRate = ($completedPrograms / $totalPrograms) * 50;
        $taskRate = $tasksCount > 0 ? ($doneTasks / $tasksCount) * 30 : 10;
        $umkmRate = $this->umkms()->count() > 0 ? 10 : 0;
        $docRate = $this->documents()->count() > 0 ? 10 : 0;

        return min(100, (int) round($progRate + $taskRate + $umkmRate + $docRate));
    }
}
