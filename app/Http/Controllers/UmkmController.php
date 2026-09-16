<?php

namespace App\Http\Controllers;

use App\Models\Village;
use App\Models\KknGroup;
use App\Models\Umkm;
use App\Models\UmkmProduct;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UmkmController extends Controller
{
    public function index(Village $village)
    {
        $umkms = $village->umkms()->with('products')->latest()->get();
        $isLocked = $village->isHandedOver() && !auth()->user()->isVillageAdmin() && !auth()->user()->isSuperAdmin();

        return view('umkm.index', compact('village', 'umkms', 'isLocked'));
    }

    public function create(Village $village)
    {
        return view('umkm.create', compact('village'));
    }

    public function store(Request $request, Village $village)
    {
        $validated = $request->validate([
            'business_name' => 'required|string|max:255',
            'owner_name' => 'required|string|max:255',
            'category' => 'required|string',
            'description' => 'nullable|string',
            'address' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'phone' => 'nullable|string|max:30',
            'whatsapp' => 'nullable|string|max:30',
            'instagram' => 'nullable|string|max:100',
        ]);

        $slug = Str::slug($validated['business_name']);
        if (Umkm::where('village_id', $village->id)->where('slug', $slug)->exists()) {
            $slug .= '-' . Str::random(4);
        }

        $activeGroup = $village->activeGroup();

        $umkm = Umkm::create([
            'village_id' => $village->id,
            'kkn_group_id' => $activeGroup?->id,
            'user_id' => auth()->id(),
            'business_name' => $validated['business_name'],
            'slug' => $slug,
            'owner_name' => $validated['owner_name'],
            'category' => $validated['category'],
            'description' => $validated['description'],
            'address' => $validated['address'],
            'latitude' => $validated['latitude'] ?? $village->latitude,
            'longitude' => $validated['longitude'] ?? $village->longitude,
            'phone' => $validated['phone'],
            'whatsapp' => $validated['whatsapp'],
            'instagram' => $validated['instagram'],
            'status' => 'DRAFT',
        ]);

        ActivityLog::create([
            'kkn_group_id' => $activeGroup?->id,
            'village_id' => $village->id,
            'user_id' => auth()->id(),
            'action' => 'added_umkm',
            'description' => "Mendaftarkan UMKM baru: {$umkm->business_name}",
            'created_at' => now(),
        ]);

        return redirect()->route('village.umkm.edit', ['village' => $village->id, 'umkm' => $umkm->id])
            ->with('success', 'Profil UMKM berhasil dibuat. Silakan tambahkan katalog produk.');
    }

    public function edit(Village $village, Umkm $umkm)
    {
        $umkm->load('products');
        $isLocked = $village->isHandedOver() && !auth()->user()->isVillageAdmin() && !auth()->user()->isSuperAdmin();

        return view('umkm.edit', compact('village', 'umkm', 'isLocked'));
    }

    public function update(Request $request, Village $village, Umkm $umkm)
    {
        $validated = $request->validate([
            'business_name' => 'required|string|max:255',
            'owner_name' => 'required|string|max:255',
            'category' => 'required|string',
            'description' => 'nullable|string',
            'address' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'phone' => 'nullable|string|max:30',
            'whatsapp' => 'nullable|string|max:30',
            'instagram' => 'nullable|string|max:100',
        ]);

        $umkm->update($validated);

        return back()->with('success', 'Profil UMKM berhasil diperbarui.');
    }

    public function submitReview(Village $village, Umkm $umkm)
    {
        $umkm->update(['status' => 'PENDING_REVIEW']);

        ActivityLog::create([
            'kkn_group_id' => $umkm->kkn_group_id,
            'village_id' => $village->id,
            'user_id' => auth()->id(),
            'action' => 'submitted_umkm_review',
            'description' => "Mengajukan UMKM '{$umkm->business_name}' untuk review dan publikasi",
            'created_at' => now(),
        ]);

        return back()->with('success', 'UMKM berhasil diajukan untuk review.');
    }

    public function storeProduct(Request $request, Village $village, Umkm $umkm)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:100',
        ]);

        $umkm->products()->create([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'description' => $validated['description'],
            'category' => $validated['category'],
            'is_available' => true,
        ]);

        return back()->with('success', 'Produk berhasil ditambahkan ke katalog UMKM.');
    }

    public function destroyProduct(Village $village, Umkm $umkm, UmkmProduct $product)
    {
        $product->delete();
        return back()->with('success', 'Produk berhasil dihapus.');
    }

    public function destroy(Village $village, Umkm $umkm)
    {
        $umkm->delete();
        return redirect()->route('village.umkm.index', $village->id)->with('success', 'UMKM berhasil dihapus.');
    }
}
