<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MediaItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'album_id',
        'kkn_group_id',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
        'caption',
        'photographer',
        'date',
        'location',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'file_size' => 'integer',
            'sort_order' => 'integer',
        ];
    }

    public function getFileUrlAttribute(): string
    {
        return $this->file_path;
    }

    public function album(): BelongsTo
    {
        return $this->belongsTo(Album::class);
    }

    public function kknGroup(): BelongsTo
    {
        return $this->belongsTo(KknGroup::class);
    }
}
