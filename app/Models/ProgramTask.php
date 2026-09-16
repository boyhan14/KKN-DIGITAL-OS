<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProgramTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_id',
        'kkn_group_id',
        'assignee_id',
        'title',
        'description',
        'priority',
        'status',
        'due_date',
        'sort_order',
        'attachments_json',
    ];

    protected function casts(): array
    {
        return [
            'due_date' => 'date',
            'attachments_json' => 'array',
            'sort_order' => 'integer',
        ];
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function kknGroup(): BelongsTo
    {
        return $this->belongsTo(KknGroup::class);
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }
}
