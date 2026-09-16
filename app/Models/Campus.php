<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Campus extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'logo',
        'address',
        'contact_email',
        'website',
    ];

    public function kknPrograms(): HasMany
    {
        return $this->hasMany(KknProgram::class);
    }

    public function villages(): HasMany
    {
        return $this->hasMany(Village::class);
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'campus_members')->withPivot('role')->withTimestamps();
    }
}
