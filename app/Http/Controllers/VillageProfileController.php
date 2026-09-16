<?php

namespace App\Http\Controllers;

use App\Models\Village;
use App\Models\VillageProfile;
use App\Models\VillageFacility;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class VillageProfileController extends Controller
{
    public function dashboard(Village $village)
    {
        $village->load([
            'profile',
            'facilities',
            'handoverPackages',
            'groups.supervisor',
            'groups.leader',
            'groups.members'
        ]);

        $activeGroup = $village->activeGroup();
        $umkmCount = $village->umkms()->count();
        $tourismCount = $village->tourismPlaces()->count();
        $mapCount = $village->mapLocations()->count();
        $articleCount = $village->articles()->count();
        $eventCount = $village->events()->count();

        $handoverScore = $village->handoverReadinessScore();
        $isHandedOver = $village->isHandedOver();
        $handoverPackage = $village->latestHandoverPackage();

        return view('village.dashboard', compact(
            'village',
            'activeGroup',
            'umkmCount',
            'tourismCount',
            'mapCount',
            'articleCount',
            'eventCount',
            'handoverScore',
            'isHandedOver',
            'handoverPackage'
        ));
    }

    public function delegation(Village $village)
    {
        $village->load([
            'groups.supervisor',
            'groups.leader',
            'groups.members'
        ]);

        $activeGroup = $village->activeGroup();
        
        return view('village.delegation', compact('village', 'activeGroup'));
    }

    public function edit(Village $village)
    {
        $profile = $village->profile ?? $village->profile()->create(['status' => 'DRAFT']);
        $facilities = $village->facilities()->latest()->get();
        $isLocked = $village->isHandedOver() && !auth()->user()->isVillageAdmin() && !auth()->user()->isSuperAdmin();

        return view('village.profile', compact('village', 'profile', 'facilities', 'isLocked'));
    }

    public function update(Request $request, Village $village)
    {
        $validated = $request->validate([
            'history' => 'nullable|string',
            'vision' => 'nullable|string',
            'mission' => 'nullable|string',
            'geography' => 'nullable|string',
            'demographics_summary' => 'nullable|string',
            'economic_profile' => 'nullable|string',
            'theme' => 'nullable|in:modern,nature,heritage',
        ]);

        if (isset($validated['theme'])) {
            $village->update(['theme' => $validated['theme']]);
        }

        $profile = $village->profile ?? new VillageProfile(['village_id' => $village->id]);
        $profile->fill($validated);
        $profile->save();

        ActivityLog::create([
            'village_id' => $village->id,
            'user_id' => auth()->id(),
            'action' => 'updated_village_profile',
            'description' => "Memperbarui data profil Desa {$village->name}",
            'created_at' => now(),
        ]);

        return back()->with('success', 'Data profil desa berhasil disimpan.');
    }

    public function submitReview(Village $village)
    {
        if ($village->profile) {
            $village->profile->update(['status' => 'PENDING_REVIEW']);
        }

        return back()->with('success', 'Profil desa telah diajukan ke Dosen Pembimbing untuk direview.');
    }

    public function storeFacility(Request $request, Village $village)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:EDUCATION,HEALTH,GOVERNMENT,WORSHIP,PUBLIC,OTHER',
            'address' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'description' => 'nullable|string',
        ]);

        $village->facilities()->create($validated);

        return back()->with('success', 'Fasilitas desa berhasil ditambahkan.');
    }

    public function destroyFacility(Village $village, VillageFacility $facility)
    {
        $facility->delete();
        return back()->with('success', 'Fasilitas desa berhasil dihapus.');
    }
}
