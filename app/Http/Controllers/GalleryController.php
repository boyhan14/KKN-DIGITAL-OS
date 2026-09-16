<?php

namespace App\Http\Controllers;

use App\Models\Village;
use App\Models\Album;
use App\Models\MediaItem;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    public function index(Village $village)
    {
        $albums = $village->albums()->with('mediaItems')->latest()->get();
        $isLocked = $village->isHandedOver() && !auth()->user()->isVillageAdmin() && !auth()->user()->isSuperAdmin();

        return view('gallery.index', compact('village', 'albums', 'isLocked'));
    }

    public function storeAlbum(Request $request, Village $village)
    {
        $validated = $request->validate([
            'album_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $slug = Str::slug($validated['album_name']);
        if (Album::where('village_id', $village->id)->where('slug', $slug)->exists()) {
            $slug .= '-' . Str::random(4);
        }

        $activeGroup = $village->activeGroup();

        $album = Album::create([
            'village_id' => $village->id,
            'kkn_group_id' => $activeGroup?->id,
            'album_name' => $validated['album_name'],
            'slug' => $slug,
            'description' => $validated['description'] ?? null,
        ]);

        ActivityLog::create([
            'kkn_group_id' => $activeGroup?->id,
            'village_id' => $village->id,
            'user_id' => auth()->id(),
            'action' => 'created_album',
            'description' => "Membuat album dokumentasi baru: {$album->album_name}",
            'created_at' => now(),
        ]);

        return back()->with('success', 'Album baru berhasil dibuat.');
    }

    public function storeMedia(Request $request, Village $village, Album $album)
    {
        $validated = $request->validate([
            'caption' => 'nullable|string|max:255',
            'photographer' => 'nullable|string|max:100',
            'date' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'file_path' => 'nullable|string', // URL or local path
        ]);

        $activeGroup = $village->activeGroup();

        $album->mediaItems()->create([
            'kkn_group_id' => $activeGroup?->id,
            'file_path' => $validated['file_path'] ?? 'https://images.unsplash.com/photo-1596405835972-237e89cb7d5d?w=800&auto=format&fit=crop&q=80',
            'file_name' => 'Dokumentasi ' . ($validated['caption'] ?? 'KKN'),
            'file_type' => 'image/jpeg',
            'file_size' => 1024000,
            'caption' => $validated['caption'] ?? null,
            'photographer' => $validated['photographer'] ?? auth()->user()->name,
            'date' => $validated['date'] ?? now()->toDateString(),
            'location' => $validated['location'] ?? $village->name,
        ]);

        return back()->with('success', 'Foto/media berhasil ditambahkan ke album.');
    }

    public function destroyMedia(Village $village, Album $album, MediaItem $media)
    {
        $media->delete();
        return back()->with('success', 'Foto berhasil dihapus.');
    }
}
