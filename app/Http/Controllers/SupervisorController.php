<?php

namespace App\Http\Controllers;

use App\Models\KknGroup;
use App\Models\Approval;
use App\Models\Umkm;
use App\Models\TourismPlace;
use App\Models\Article;
use App\Models\Event;
use App\Models\VillageProfile;
use App\Models\ActivityLog;
use App\Models\Notification;
use App\Services\KknProgressService;
use Illuminate\Http\Request;

class SupervisorController extends Controller
{
    protected KknProgressService $progressService;

    public function __construct(KknProgressService $progressService)
    {
        $this->progressService = $progressService;
    }

    public function dashboard()
    {
        $user = auth()->user();
        
        $groupsQuery = $user->isSuperAdmin() 
            ? KknGroup::query() 
            : KknGroup::where('supervisor_id', $user->id);

        $groups = $groupsQuery->with(['village', 'leader', 'members', 'programs'])->get();

        $groupProgress = [];
        foreach ($groups as $group) {
            $groupProgress[$group->id] = $this->progressService->calculateProgress($group);
        }

        // Pending review items
        $pendingUmkms = Umkm::whereIn('kkn_group_id', $groups->pluck('id'))->where('status', 'PENDING_REVIEW')->get();
        $pendingTourism = TourismPlace::whereIn('kkn_group_id', $groups->pluck('id'))->where('status', 'PENDING_REVIEW')->get();
        $pendingArticles = Article::whereIn('kkn_group_id', $groups->pluck('id'))->where('status', 'PENDING_REVIEW')->get();
        $pendingEvents = Event::whereIn('kkn_group_id', $groups->pluck('id'))->where('status', 'PENDING_REVIEW')->get();

        $totalPending = $pendingUmkms->count() + $pendingTourism->count() + $pendingArticles->count() + $pendingEvents->count();

        return view('supervisor.dashboard', compact(
            'groups', 
            'groupProgress', 
            'pendingUmkms', 
            'pendingTourism', 
            'pendingArticles', 
            'pendingEvents',
            'totalPending'
        ));
    }

    public function review(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:umkm,tourism,article,event,profile',
            'id' => 'required|integer',
            'action' => 'required|in:APPROVE,REJECT',
            'comments' => 'nullable|string',
        ]);

        $model = match ($validated['type']) {
            'umkm' => Umkm::findOrFail($validated['id']),
            'tourism' => TourismPlace::findOrFail($validated['id']),
            'article' => Article::findOrFail($validated['id']),
            'event' => Event::findOrFail($validated['id']),
            'profile' => VillageProfile::findOrFail($validated['id']),
        };

        $newStatus = $validated['action'] === 'APPROVE' ? 'PUBLISHED' : 'DRAFT';
        $model->update(['status' => $newStatus]);

        if ($validated['type'] === 'article' && $validated['action'] === 'APPROVE') {
            $model->update(['published_at' => now()]);
        }

        // Record approval history
        Approval::create([
            'approvable_type' => get_class($model),
            'approvable_id' => $model->id,
            'reviewer_id' => auth()->id(),
            'status' => $validated['action'] === 'APPROVE' ? 'APPROVED' : 'REJECTED',
            'comments' => $validated['comments'] ?? null,
            'reviewed_at' => now(),
        ]);

        // Record Activity Log
        ActivityLog::create([
            'kkn_group_id' => $model->kkn_group_id ?? null,
            'village_id' => $model->village_id ?? null,
            'user_id' => auth()->id(),
            'action' => strtolower($validated['action']) . '_content',
            'description' => "Dosen Pembimbing " . ($validated['action'] === 'APPROVE' ? 'menyetujui publikasi' : 'menolak/meminta revisi') . " pada item " . ($model->title ?? $model->name ?? $model->business_name ?? 'Konten'),
            'created_at' => now(),
        ]);

        $msg = $validated['action'] === 'APPROVE' 
            ? 'Konten berhasil disetujui dan sekarang tampil di website publik!' 
            : 'Konten dikembalikan ke draft dengan catatan revisi.';

        return back()->with('success', $msg);
    }
}
