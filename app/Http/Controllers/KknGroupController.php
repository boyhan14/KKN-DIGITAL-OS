<?php

namespace App\Http\Controllers;

use App\Models\KknGroup;
use App\Services\KknProgressService;
use App\Services\TenantService;
use Illuminate\Http\Request;

class KknGroupController extends Controller
{
    protected KknProgressService $progressService;
    protected TenantService $tenantService;

    public function __construct(KknProgressService $progressService, TenantService $tenantService)
    {
        $this->progressService = $progressService;
        $this->tenantService = $tenantService;
    }

    public function workspace(KknGroup $group)
    {
        $group->load([
            'village.profile',
            'programs.tasks',
            'supervisor',
            'leader',
            'members',
            'activityLogs.user',
            'handoverPackages'
        ]);

        $progressData = $this->progressService->calculateProgress($group);

        $taskCounts = [
            'todo' => $group->tasks()->where('status', 'TODO')->count(),
            'in_progress' => $group->tasks()->where('status', 'IN_PROGRESS')->count(),
            'review' => $group->tasks()->where('status', 'REVIEW')->count(),
            'done' => $group->tasks()->where('status', 'DONE')->count(),
        ];

        $recentLogs = $group->activityLogs()->with('user')->latest()->take(8)->get();
        $isLocked = $group->status === 'COMPLETED';

        return view('group.workspace', compact('group', 'progressData', 'taskCounts', 'recentLogs', 'isLocked'));
    }

    public function members(KknGroup $group)
    {
        $group->load(['members', 'supervisor', 'leader']);
        return view('group.members', compact('group'));
    }

    public function activity(KknGroup $group)
    {
        $logs = $group->activityLogs()->with('user')->latest()->paginate(20);
        return view('group.activity', compact('group', 'logs'));
    }
}
