<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HandoverItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'handover_package_id',
        'title',
        'category',
        'status',
        'notes',
    ];

    public function handoverPackage(): BelongsTo
    {
        return $this->belongsTo(HandoverPackage::class);
    }
}

