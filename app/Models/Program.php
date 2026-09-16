<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'kkn_group_id',
        'village_id',
        'leader_id',
        'title',
        'slug',
        'description',
        'category',
        'objective',
        'target_audience',
        'location',
        'start_date',
        'end_date',
        'budget',
        'priority',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'budget' => 'decimal:2',
        ];
    }

    public function kknGroup(): BelongsTo
    {
        return $this->belongsTo(KknGroup::class);
    }

    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }

    public function leader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'leader_id');
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'program_members')
            ->withPivot('role')
            ->withTimestamps();
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(ProgramTask::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(ProgramDocument::class);
    }

    public function impactMetrics(): HasMany
    {
        return $this->hasMany(ImpactMetric::class);
    }

    public function isCompleted(): bool
    {
        return $this->status === 'COMPLETED';
    }
}
