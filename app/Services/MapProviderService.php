<?php

namespace App\Services;

use App\Models\Village;

class MapProviderService
{
    /**
     * Build GeoJSON or marker array for a village map.
     */
    public function getVillageMarkers(Village $village): array
    {
        $markers = [];

        // 1. Village Office (Center)
        if ($village->latitude && $village->longitude) {
            $markers[] = [
                'id' => 'office_' . $village->id,
                'title' => 'Kantor Balai Desa ' . $village->name,
                'category' => 'OFFICE',
                'category_label' => 'Kantor Desa',
                'lat' => (float) $village->latitude,
                'lng' => (float) $village->longitude,
                'description' => 'Pusat pemerintahan dan pelayanan warga Desa ' . $village->name,
                'icon' => 'building-2',
                'url' => route('public.village.about', $village->slug),
            ];
        }

        // 2. Published UMKMs
        foreach ($village->publishedUmkms as $umkm) {
            if ($umkm->latitude && $umkm->longitude) {
                $markers[] = [
                    'id' => 'umkm_' . $umkm->id,
                    'title' => $umkm->business_name,
                    'category' => 'UMKM',
                    'category_label' => 'UMKM: ' . $umkm->category,
                    'lat' => (float) $umkm->latitude,
                    'lng' => (float) $umkm->longitude,
                    'description' => $umkm->owner_name . ' - ' . substr($umkm->description ?? '', 0, 80) . '...',
                    'icon' => 'shopping-bag',
                    'whatsapp' => $umkm->whatsapp_link,
                    'url' => route('public.village.umkm.show', [$village->slug, $umkm->slug]),
                ];
            }
        }

        // 3. Published Tourism Places
        foreach ($village->publishedTourismPlaces as $tour) {
            if ($tour->latitude && $tour->longitude) {
                $markers[] = [
                    'id' => 'tour_' . $tour->id,
                    'title' => $tour->name,
                    'category' => 'TOURISM',
                    'category_label' => 'Wisata: ' . $tour->category,
                    'lat' => (float) $tour->latitude,
                    'lng' => (float) $tour->longitude,
                    'description' => $tour->opening_hours . ' | HTM: Rp ' . number_format($tour->ticket_price, 0, ',', '.'),
                    'icon' => 'compass',
                    'url' => route('public.village.tourism', $village->slug),
                ];
            }
        }

        // 4. Facilities
        foreach ($village->facilities as $fac) {
            if ($fac->latitude && $fac->longitude) {
                $markers[] = [
                    'id' => 'fac_' . $fac->id,
                    'title' => $fac->name,
                    'category' => 'FACILITY',
                    'category_label' => 'Fasilitas: ' . $fac->category,
                    'lat' => (float) $fac->latitude,
                    'lng' => (float) $fac->longitude,
                    'description' => $fac->description,
                    'icon' => 'map-pin',
                    'url' => null,
                ];
            }
        }

        // 5. Custom Map Locations
        foreach ($village->mapLocations as $loc) {
            $markers[] = [
                'id' => 'loc_' . $loc->id,
                'title' => $loc->title,
                'category' => $loc->category,
                'category_label' => ucfirst(strtolower($loc->category)),
                'lat' => (float) $loc->latitude,
                'lng' => (float) $loc->longitude,
                'description' => $loc->description,
                'icon' => $loc->icon ?? 'pin',
                'url' => null,
            ];
        }

        return $markers;
    }
}
