<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Umkm extends Model
{
    use HasFactory;

    protected $fillable = [
        'village_id',
        'kkn_group_id',
        'user_id',
        'business_name',
        'slug',
        'owner_name',
        'category',
        'description',
        'address',
        'latitude',
        'longitude',
        'phone',
        'whatsapp',
        'instagram',
        'logo',
        'cover_image',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'float',
            'longitude' => 'float',
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

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(UmkmProduct::class);
    }

    public function availableProducts(): HasMany
    {
        return $this->hasMany(UmkmProduct::class)->where('is_available', true);
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

    public function getWhatsappLinkAttribute(): ?string
    {
        if (empty($this->whatsapp)) {
            return null;
        }
        $number = preg_replace('/[^0-9]/', '', $this->whatsapp);
        if (str_starts_with($number, '0')) {
            $number = '62' . substr($number, 1);
        }
        return "https://wa.me/{$number}?text=" . urlencode("Halo {$this->business_name}, saya melihat profil UMKM Anda di website desa.");
    }
}
