<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VillageProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'village_id',
        'history',
        'vision',
        'mission',
        'geography',
        'demographics_summary',
        'economic_profile',
        'status',
    ];

    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }

    public function isPublished(): bool
    {
        return $this->status === 'PUBLISHED';
    }
}
