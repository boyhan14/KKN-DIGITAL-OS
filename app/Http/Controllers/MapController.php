<?php

namespace App\Http\Controllers;

use App\Models\Village;
use App\Models\MapLocation;
use App\Services\MapProviderService;
use Illuminate\Http\Request;

class MapController extends Controller
{
    protected MapProviderService $mapService;

    public function __construct(MapProviderService $mapService)
    {
        $this->mapService = $mapService;
    }

    public function index(Village $village)
    {
        $markers = $this->mapService->getVillageMarkers($village);
        $customLocations = $village->mapLocations()->latest()->get();
        $isLocked = !app(\App\Services\TenantService::class)->canManageVillage(auth()->user(), $village);

        return view('map.index', compact('village', 'markers', 'customLocations', 'isLocked'));
    }

    public function store(Request $request, Village $village)
    {
        if (!app(\App\Services\TenantService::class)->canManageVillage(auth()->user(), $village)) {
            abort(403, 'Anda tidak memiliki wewenang untuk menambahkan titik peta desa ini.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:UMKM,TOURISM,FACILITY,OFFICE,KKN_PROGRAM,OTHER',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
        ]);

        $village->mapLocations()->create($validated);

        return back()->with('success', 'Titik peta baru berhasil ditambahkan.');
    }

    public function destroy(Village $village, MapLocation $location)
    {
        if (!app(\App\Services\TenantService::class)->canManageVillage(auth()->user(), $village)) {
            abort(403, 'Anda tidak memiliki wewenang untuk menghapus titik peta desa.');
        }

        $location->delete();
        return back()->with('success', 'Titik peta berhasil dihapus.');
    }
}
