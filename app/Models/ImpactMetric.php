<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ImpactMetric extends Model
{
    use HasFactory;

    protected $fillable = [
        'kkn_group_id',
        'village_id',
        'program_id',
        'metric_name',
        'category',
        'baseline',
        'target',
        'achieved',
        'unit',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'baseline' => 'integer',
            'target' => 'integer',
            'achieved' => 'integer',
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

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function progressPercentage(): int
    {
        if ($this->target <= 0) {
            return $this->achieved > 0 ? 100 : 0;
        }
        return (int) min(100, round(($this->achieved / $this->target) * 100));
    }
}
