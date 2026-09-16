<?php

namespace App\Http\Controllers;

use App\Models\Village;
use App\Models\Event;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EventController extends Controller
{
    public function index(Village $village)
    {
        $events = $village->events()->orderBy('date', 'desc')->get();
        $isLocked = $village->isHandedOver() && !auth()->user()->isVillageAdmin() && !auth()->user()->isSuperAdmin();

        return view('events.index', compact('village', 'events', 'isLocked'));
    }

    public function store(Request $request, Village $village)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'start_time' => 'nullable',
            'end_time' => 'nullable',
            'location' => 'nullable|string|max:255',
            'organizer' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $slug = Str::slug($validated['title']);
        if (Event::where('village_id', $village->id)->where('slug', $slug)->exists()) {
            $slug .= '-' . Str::random(4);
        }

        $activeGroup = $village->activeGroup();

        $event = Event::create([
            'village_id' => $village->id,
            'kkn_group_id' => $activeGroup?->id,
            'title' => $validated['title'],
            'slug' => $slug,
            'date' => $validated['date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'location' => $validated['location'],
            'organizer' => $validated['organizer'] ?? 'Pemerintah Desa / Tim KKN',
            'description' => $validated['description'],
            'status' => 'DRAFT',
        ]);

        ActivityLog::create([
            'kkn_group_id' => $activeGroup?->id,
            'village_id' => $village->id,
            'user_id' => auth()->id(),
            'action' => 'added_event',
            'description' => "Menambahkan agenda kegiatan: {$event->title}",
            'created_at' => now(),
        ]);

        return back()->with('success', 'Agenda kegiatan berhasil dibuat.');
    }

    public function submitReview(Village $village, Event $event)
    {
        $event->update(['status' => 'PENDING_REVIEW']);
        return back()->with('success', 'Agenda kegiatan diajukan untuk review.');
    }

    public function destroy(Village $village, Event $event)
    {
        $event->delete();
        return back()->with('success', 'Kegiatan berhasil dihapus.');
    }
}
