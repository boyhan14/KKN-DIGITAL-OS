<?php

namespace App\Services;

use App\Models\KknGroup;

class KknProgressService
{
    /**
     * Calculate detailed progress breakdown for a KKN group.
     */
    public function calculateProgress(KknGroup $group): array
    {
        $village = $group->village;

        // 1. Village Profile Completion (10%)
        $profileScore = 0;
        if ($village && $village->profile) {
            if ($village->profile->status === 'PUBLISHED') {
                $profileScore = 10;
            } elseif (!empty($village->profile->vision)) {
                $profileScore = 5;
            }
        }

        // 2. Programs Completion (20%)
        $programs = $group->programs;
        $progScore = 0;
        if ($programs->count() > 0) {
            $completed = $programs->where('status', 'COMPLETED')->count();
            $progScore = (int) round(($completed / $programs->count()) * 20);
        }

        // 3. Village Data & Facilities (15%)
        $facilitiesCount = $village ? $village->facilities()->count() : 0;
        $facilityScore = min(15, $facilitiesCount * 3);

        // 4. UMKM Directory (15%)
        $umkmCount = $group->umkms()->count();
        $umkmScore = min(15, $umkmCount * 3);

        // 5. Tourism Spots (10%)
        $tourismCount = $group->tourismPlaces()->count();
        $tourismScore = min(10, $tourismCount * 5);

        // 6. Documentation & Media (10%)
        $docCount = $group->documents()->count();
        $mediaCount = $group->albums()->withCount('mediaItems')->get()->sum('media_items_count');
        $docScore = min(10, ($docCount * 2) + ($mediaCount > 5 ? 5 : 2));

        // 7. Impact Metrics (10%)
        $metricsCount = $group->impactMetrics()->count();
        $metricScore = min(10, $metricsCount * 2);

        // 8. Handover Readiness (10%)
        $readinessScore = $village ? (int) round(($village->handoverReadinessScore() / 100) * 10) : 0;

        $total = $profileScore + $progScore + $facilityScore + $umkmScore + $tourismScore + $docScore + $metricScore + $readinessScore;

        return [
            'total' => min(100, $total),
            'breakdown' => [
                'profile' => ['score' => $profileScore, 'max' => 10, 'label' => 'Profil Desa'],
                'programs' => ['score' => $progScore, 'max' => 20, 'label' => 'Program Kerja'],
                'facilities' => ['score' => $facilityScore, 'max' => 15, 'label' => 'Fasilitas & Data Desa'],
                'umkm' => ['score' => $umkmScore, 'max' => 15, 'label' => 'Digitalisasi UMKM'],
                'tourism' => ['score' => $tourismScore, 'max' => 10, 'label' => 'Potensi Wisata'],
                'documentation' => ['score' => $docScore, 'max' => 10, 'label' => 'Dokumentasi & Media'],
                'impact' => ['score' => $metricScore, 'max' => 10, 'label' => 'Metrik Dampak (Impact)'],
                'handover' => ['score' => $readinessScore, 'max' => 10, 'label' => 'Kesiapan Handover'],
            ],
        ];
    }
}
