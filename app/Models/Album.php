<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Album extends Model
{
    use HasFactory;

    protected $fillable = [
        'village_id',
        'kkn_group_id',
        'album_name',
        'slug',
        'description',
        'cover_image',
    ];

    public function getTitleAttribute(): string
    {
        return $this->album_name;
    }

    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }

    public function kknGroup(): BelongsTo
    {
        return $this->belongsTo(KknGroup::class);
    }

    public function mediaItems(): HasMany
    {
        return $this->hasMany(MediaItem::class)->orderBy('sort_order', 'asc');
    }
}
