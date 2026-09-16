<?php

namespace App\Http\Controllers;

use App\Models\Village;
use App\Models\TourismPlace;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TourismController extends Controller
{
    public function index(Village $village)
    {
        $tourismPlaces = $village->tourismPlaces()->latest()->get();
        $isLocked = $village->isHandedOver() && !auth()->user()->isVillageAdmin() && !auth()->user()->isSuperAdmin();

        return view('tourism.index', compact('village', 'tourismPlaces', 'isLocked'));
    }

    public function create(Village $village)
    {
        return view('tourism.create', compact('village'));
    }

    public function store(Request $request, Village $village)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:NATURE,CULINARY,CULTURE,CRAFT,HISTORY,RELIGIOUS,ADVENTURE,OTHER',
            'description' => 'nullable|string',
            'address' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'opening_hours' => 'nullable|string',
            'ticket_price' => 'nullable|numeric|min:0',
            'contact' => 'nullable|string|max:50',
        ]);

        $slug = Str::slug($validated['name']);
        if (TourismPlace::where('village_id', $village->id)->where('slug', $slug)->exists()) {
            $slug .= '-' . Str::random(4);
        }

        $activeGroup = $village->activeGroup();

        $tourism = TourismPlace::create([
            'village_id' => $village->id,
            'kkn_group_id' => $activeGroup?->id,
            'name' => $validated['name'],
            'slug' => $slug,
            'category' => $validated['category'],
            'description' => $validated['description'],
            'address' => $validated['address'],
            'latitude' => $validated['latitude'] ?? $village->latitude,
            'longitude' => $validated['longitude'] ?? $village->longitude,
            'opening_hours' => $validated['opening_hours'] ?? 'Setiap Hari, 08.00 - 17.00 WIB',
            'ticket_price' => $validated['ticket_price'] ?? 0,
            'contact' => $validated['contact'],
            'status' => 'DRAFT',
        ]);

        ActivityLog::create([
            'kkn_group_id' => $activeGroup?->id,
            'village_id' => $village->id,
            'user_id' => auth()->id(),
            'action' => 'added_tourism',
            'description' => "Menambahkan potensi wisata baru: {$tourism->name}",
            'created_at' => now(),
        ]);

        return redirect()->route('village.tourism.index', $village->id)->with('success', 'Destinasi wisata berhasil didaftarkan.');
    }

    public function edit(Village $village, TourismPlace $tourism)
    {
        $isLocked = $village->isHandedOver() && !auth()->user()->isVillageAdmin() && !auth()->user()->isSuperAdmin();
        return view('tourism.edit', compact('village', 'tourism', 'isLocked'));
    }

    public function update(Request $request, Village $village, TourismPlace $tourism)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:NATURE,CULINARY,CULTURE,CRAFT,HISTORY,RELIGIOUS,ADVENTURE,OTHER',
            'description' => 'nullable|string',
            'address' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'opening_hours' => 'nullable|string',
            'ticket_price' => 'nullable|numeric|min:0',
            'contact' => 'nullable|string|max:50',
        ]);

        $tourism->update($validated);

        return back()->with('success', 'Data potensi wisata berhasil diperbarui.');
    }

    public function submitReview(Village $village, TourismPlace $tourism)
    {
        $tourism->update(['status' => 'PENDING_REVIEW']);

        ActivityLog::create([
            'kkn_group_id' => $tourism->kkn_group_id,
            'village_id' => $village->id,
            'user_id' => auth()->id(),
            'action' => 'submitted_tourism_review',
            'description' => "Mengajukan destinasi wisata '{$tourism->name}' untuk review dan publikasi",
            'created_at' => now(),
        ]);

        return back()->with('success', 'Destinasi wisata diajukan untuk review.');
    }

    public function destroy(Village $village, TourismPlace $tourism)
    {
        $tourism->delete();
        return redirect()->route('village.tourism.index', $village->id)->with('success', 'Destinasi wisata dihapus.');
    }
}
