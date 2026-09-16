<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProgramDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_id',
        'kkn_group_id',
        'title',
        'file_path',
        'file_type',
        'file_size',
        'visibility',
    ];

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function kknGroup(): BelongsTo
    {
        return $this->belongsTo(KknGroup::class);
    }

    public function isPublic(): bool
    {
        return $this->visibility === 'PUBLIC';
    }
}
