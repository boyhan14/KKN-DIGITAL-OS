<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'kkn_group_id',
        'village_id',
        'title',
        'type',
        'status',
        'content_json',
        'generated_at',
    ];

    protected function casts(): array
    {
        return [
            'content_json' => 'array',
            'generated_at' => 'datetime',
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
}
