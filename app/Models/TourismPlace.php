<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class TourismPlace extends Model
{
    use HasFactory;

    protected $fillable = [
        'village_id',
        'kkn_group_id',
        'name',
        'slug',
        'category',
        'description',
        'address',
        'latitude',
        'longitude',
        'opening_hours',
        'ticket_price',
        'contact',
        'cover_image',
        'gallery_json',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'float',
            'longitude' => 'float',
            'ticket_price' => 'decimal:2',
            'gallery_json' => 'array',
        ];
    }

    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }

    public function kknGroup(): BelongsTo
    {
        return $this->belongsTo(KknGroup::class);
    }

    public function approvals(): MorphMany
    {
        return $this->morphMany(Approval::class, 'approvable');
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function isPublished(): bool
    {
        return $this->status === 'PUBLISHED';
    }
}
