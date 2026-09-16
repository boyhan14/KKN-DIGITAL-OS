<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KknProgram extends Model
{
    use HasFactory;

    protected $fillable = [
        'campus_id',
        'name',
        'year',
        'period',
        'start_date',
        'end_date',
        'description',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    public function campus(): BelongsTo
    {
        return $this->belongsTo(Campus::class);
    }

    public function villages(): HasMany
    {
        return $this->hasMany(Village::class);
    }

    public function groups(): HasMany
    {
        return $this->hasMany(KknGroup::class);
    }

    public function isActive(): bool
    {
        return $this->status === 'ACTIVE';
    }
}
