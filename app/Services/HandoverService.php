<?php

namespace App\Services;

use App\Models\KknGroup;
use App\Models\Village;
use App\Models\User;
use App\Models\HandoverPackage;
use App\Models\HandoverItem;
use App\Models\ActivityLog;
use App\Models\AuditLog;
use App\Models\VillageAdmin;
use Illuminate\Support\Facades\DB;

class HandoverService
{
    /**
     * Get checklist status for a village/group handover.
     */
    public function getChecklist(KknGroup $group): array
    {
        $village = $group->village;

        return [
            [
                'id' => 'profile',
                'title' => 'Profil Desa Terstruktur',
                'description' => 'Visi, misi, sejarah, demografi, dan potensi desa telah diisi lengkap.',
                'status' => ($village->profile && !empty($village->profile->vision)) ? 'COMPLETED' : 'PENDING',
                'category' => 'WEBSITE',
            ],
            [
                'id' => 'umkm',
                'title' => 'Katalog UMKM Digital',
                'description' => 'Minimal 3 profil UMKM lokal terdaftar beserta produk dan kontak WhatsApp.',
                'status' => $group->umkms()->where('status', 'PUBLISHED')->count() >= 3 ? 'COMPLETED' : 'PENDING',
                'category' => 'UMKM',
            ],
            [
                'id' => 'tourism',
                'title' => 'Direktori Wisata Desa',
                'description' => 'Potensi wisata desa terdokumentasi dengan foto, rute, dan jam operasional.',
                'status' => $group->tourismPlaces()->where('status', 'PUBLISHED')->count() >= 1 ? 'COMPLETED' : 'PENDING',
                'category' => 'TOURISM',
            ],
            [
                'id' => 'map',
                'title' => 'Peta Digital Interaktif',
                'description' => 'Titik lokasi fasilitas, UMKM, dan spot penting sudah ditandai di peta.',
                'status' => $village->mapLocations()->count() >= 2 ? 'COMPLETED' : 'PENDING',
                'category' => 'WEBSITE',
            ],
            [
                'id' => 'documentation',
                'title' => 'Dokumentasi & Galeri Program',
                'description' => 'Arsip foto dan dokumen luaran KKN tersimpan terstruktur.',
                'status' => ($group->documents()->count() >= 1 && $group->albums()->count() >= 1) ? 'COMPLETED' : 'PENDING',
                'category' => 'DOCUMENTATION',
            ],
            [
                'id' => 'impact',
                'title' => 'Metrik Capaian & Dampak (Impact)',
                'description' => 'Angka penerima manfaat, UMKM terdigitalisasi, dan luaran program tercatat.',
                'status' => $group->impactMetrics()->count() >= 2 ? 'COMPLETED' : 'PENDING',
                'category' => 'IMPACT',
            ],
            [
                'id' => 'admin_account',
                'title' => 'Akun Perangkat Desa (Village Admin)',
                'description' => 'Akun staf/perangkat desa sudah didaftarkan untuk menerima serah terima.',
                'status' => $village->admins()->wherePivot('is_active', true)->exists() ? 'COMPLETED' : 'PENDING',
                'category' => 'ADMIN_ACCESS',
            ],
            [
                'id' => 'training_notes',
                'title' => 'Panduan & Berita Acara Serah Terima',
                'description' => 'Catatan pelatihan pengelolaan website untuk perangkat desa.',
                'status' => 'COMPLETED',
                'category' => 'ADMIN_ACCESS',
            ],
        ];
    }

    /**
     * Compute readiness percentage.
     */
    public function calculateReadiness(KknGroup $group): int
    {
        $checklist = $this->getChecklist($group);
        $total = count($checklist);
        $completed = count(array_filter($checklist, fn($item) => $item['status'] === 'COMPLETED'));

        return (int) round(($completed / $total) * 100);
    }

    /**
     * Execute or generate digital handover package.
     */
    public function createOrUpdatePackage(KknGroup $group, array $data, ?User $actor = null): HandoverPackage
    {
        $village = $group->village;
        $readiness = $this->calculateReadiness($group);
        $checklist = $this->getChecklist($group);

        return DB::transaction(function () use ($group, $village, $data, $readiness, $checklist, $actor) {
            $package = HandoverPackage::updateOrCreate(
                [
                    'kkn_group_id' => $group->id,
                    'village_id' => $village->id,
                ],
                [
                    'title' => $data['title'] ?? ("Berita Acara Digital Handover - " . $village->name),
                    'notes' => $data['notes'] ?? 'Serah terima aset digital dari kelompok KKN kepada Pemerintah Desa.',
                    'readiness_score' => $readiness,
                    'handover_date' => $data['handover_date'] ?? now()->toDateString(),
                    'village_admin_id' => $data['village_admin_id'] ?? null,
                    'status' => $data['status'] ?? 'DRAFT',
                    'checklist_json' => $checklist,
                ]
            );

            // Sync items
            $package->items()->delete();
            foreach ($checklist as $item) {
                HandoverItem::create([
                    'handover_package_id' => $package->id,
                    'title' => $item['title'],
                    'category' => $item['category'],
                    'status' => $item['status'],
                    'notes' => $item['description'],
                ]);
            }

            // If finalized / completed, transfer operational ownership
            if ($package->status === 'COMPLETED') {
                $package->update(['completed_at' => now()]);

                // 1. Mark group as COMPLETED
                $group->update(['status' => 'COMPLETED']);

                // 2. Ensure Village Admin is active
                if ($package->village_admin_id) {
                    VillageAdmin::updateOrCreate(
                        [
                            'village_id' => $village->id,
                            'user_id' => $package->village_admin_id,
                        ],
                        [
                            'is_active' => true,
                            'assigned_at' => now(),
                        ]
                    );

                    // Update role of the user to VILLAGE_ADMIN if not already
                    $vAdminUser = User::find($package->village_admin_id);
                    if ($vAdminUser && $vAdminUser->role !== 'SUPER_ADMIN') {
                        $vAdminUser->update(['role' => 'VILLAGE_ADMIN']);
                    }
                }

                ActivityLog::create([
                    'kkn_group_id' => $group->id,
                    'village_id' => $village->id,
                    'user_id' => $actor?->id,
                    'action' => 'completed_handover',
                    'description' => "Digital Handover resmi diselesaikan. Kepemilikan website dialihkan ke Perangkat Desa.",
                    'created_at' => now(),
                ]);

                AuditLog::create([
                    'user_id' => $actor?->id,
                    'action' => 'handover_completed',
                    'resource' => "Village:{$village->id}",
                    'details_json' => ['group_id' => $group->id, 'village_admin_id' => $package->village_admin_id],
                ]);
            }

            return $package;
        });
    }
}
