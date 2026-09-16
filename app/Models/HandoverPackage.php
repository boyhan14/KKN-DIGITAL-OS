<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HandoverPackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'kkn_group_id',
        'village_id',
        'title',
        'notes',
        'readiness_score',
        'handover_date',
        'village_admin_id',
        'status',
        'checklist_json',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'handover_date' => 'date',
            'checklist_json' => 'array',
            'readiness_score' => 'integer',
            'completed_at' => 'datetime',
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

    public function villageAdmin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'village_admin_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(HandoverItem::class);
    }

    public function isCompleted(): bool
    {
        return $this->status === 'COMPLETED';
    }
}
