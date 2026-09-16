<?php

namespace App\Http\Controllers;

use App\Models\KknGroup;
use App\Models\User;
use App\Services\HandoverService;
use App\Services\TenantService;
use Illuminate\Http\Request;

class HandoverController extends Controller
{
    protected HandoverService $handoverService;
    protected TenantService $tenantService;

    public function __construct(HandoverService $handoverService, TenantService $tenantService)
    {
        $this->handoverService = $handoverService;
        $this->tenantService = $tenantService;
    }

    public function index(KknGroup $group)
    {
        $village = $group->village;
        $checklist = $this->handoverService->getChecklist($group);
        $readinessScore = $this->handoverService->calculateReadiness($group);
        $package = $group->handoverPackages()->latest()->first();
        
        $villageUsers = User::whereIn('role', ['VILLAGE_ADMIN', 'PUBLIC', 'STUDENT'])->get();
        $isLocked = $group->status === 'COMPLETED';

        return view('handover.index', compact('group', 'village', 'checklist', 'readinessScore', 'package', 'villageUsers', 'isLocked'));
    }

    public function execute(Request $request, KknGroup $group)
    {
        $validated = $request->validate([
            'village_admin_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'handover_date' => 'required|date',
            'confirm_finalize' => 'required|accepted',
        ]);

        $package = $this->handoverService->createOrUpdatePackage($group, [
            'village_admin_id' => $validated['village_admin_id'],
            'title' => $validated['title'],
            'notes' => $validated['notes'],
            'handover_date' => $validated['handover_date'],
            'status' => 'COMPLETED',
        ], auth()->user());

        return redirect()->route('group.handover.certificate', ['group' => $group->id, 'package' => $package->id])
            ->with('success', 'Digital Handover Berhasil Diselesaikan! Kepemilikan operasional website desa resmi dialihkan ke Perangkat Desa.');
    }

    public function certificate(KknGroup $group)
    {
        $package = $group->handoverPackages()->latest()->firstOrFail();
        $village = $group->village;
        $supervisor = $group->supervisor;
        $leader = $group->leader;
        $villageAdmin = $package->villageAdmin;

        return view('handover.certificate', compact('group', 'village', 'package', 'supervisor', 'leader', 'villageAdmin'));
    }
}
