<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Village extends Model
{
    use HasFactory;

    protected $fillable = [
        'campus_id',
        'kkn_program_id',
        'name',
        'slug',
        'province',
        'regency',
        'district',
        'postal_code',
        'latitude',
        'longitude',
        'head_name',
        'contact',
        'email',
        'website',
        'logo',
        'cover_image',
        'description',
        'theme',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'float',
            'longitude' => 'float',
            'is_active' => 'boolean',
        ];
    }

    public function campus(): BelongsTo
    {
        return $this->belongsTo(Campus::class);
    }

    public function kknProgram(): BelongsTo
    {
        return $this->belongsTo(KknProgram::class);
    }

    public function groups(): HasMany
    {
        return $this->hasMany(KknGroup::class);
    }

    public function activeGroup()
    {
        return $this->groups()->where('status', 'ACTIVE')->latest()->first() ?? $this->groups()->latest()->first();
    }

    public function profile(): HasOne
    {
        return $this->hasOne(VillageProfile::class);
    }

    public function facilities(): HasMany
    {
        return $this->hasMany(VillageFacility::class);
    }

    public function umkms(): HasMany
    {
        return $this->hasMany(Umkm::class);
    }

    public function publishedUmkms(): HasMany
    {
        return $this->hasMany(Umkm::class)->where('status', 'PUBLISHED');
    }

    public function tourismPlaces(): HasMany
    {
        return $this->hasMany(TourismPlace::class);
    }

    public function publishedTourismPlaces(): HasMany
    {
        return $this->hasMany(TourismPlace::class)->where('status', 'PUBLISHED');
    }

    public function mapLocations(): HasMany
    {
        return $this->hasMany(MapLocation::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function publishedEvents(): HasMany
    {
        return $this->hasMany(Event::class)->where('status', 'PUBLISHED');
    }

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    public function publishedArticles(): HasMany
    {
        return $this->hasMany(Article::class)->where('status', 'PUBLISHED');
    }

    public function albums(): HasMany
    {
        return $this->hasMany(Album::class);
    }

    public function impactMetrics(): HasMany
    {
        return $this->hasMany(ImpactMetric::class);
    }

    public function handoverPackages(): HasMany
    {
        return $this->hasMany(HandoverPackage::class);
    }

    public function latestHandoverPackage()
    {
        return $this->handoverPackages()->latest()->first();
    }

    public function admins(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'village_admins')
            ->withPivot('is_active', 'assigned_at')
            ->withTimestamps();
    }

    public function isHandedOver(): bool
    {
        $pkg = $this->latestHandoverPackage();
        return $pkg && $pkg->status === 'COMPLETED';
    }

    public function handoverReadinessScore(): int
    {
        $score = 0;
        // 1. Village profile (20%)
        if ($this->profile && $this->profile->status === 'PUBLISHED') {
            $score += 20;
        } elseif ($this->profile && !empty($this->profile->vision)) {
            $score += 10;
        }

        // 2. UMKM >= 3 published (20%)
        $umkmCount = $this->publishedUmkms()->count();
        if ($umkmCount >= 3) {
            $score += 20;
        } elseif ($umkmCount > 0) {
            $score += 10;
        }

        // 3. Tourism places (15%)
        $tourismCount = $this->publishedTourismPlaces()->count();
        if ($tourismCount >= 1) {
            $score += 15;
        }

        // 4. Map locations (10%)
        if ($this->mapLocations()->count() >= 2) {
            $score += 10;
        }

        // 5. Articles or Events (15%)
        if ($this->publishedArticles()->count() >= 1 || $this->publishedEvents()->count() >= 1) {
            $score += 15;
        }

        // 6. Village Admin account assigned (20%)
        if ($this->admins()->wherePivot('is_active', true)->exists()) {
            $score += 20;
        }

        return min(100, $score);
    }
}
