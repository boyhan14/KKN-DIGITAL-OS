<?php

namespace App\Http\Controllers;

use App\Models\KknGroup;
use App\Models\Report;
use App\Services\ImpactService;
use App\Services\KknProgressService;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    protected ImpactService $impactService;
    protected KknProgressService $progressService;

    public function __construct(ImpactService $impactService, KknProgressService $progressService)
    {
        $this->impactService = $impactService;
        $this->progressService = $progressService;
    }

    public function index(KknGroup $group)
    {
        $reports = $group->reports()->latest()->get();
        return view('reports.index', compact('group', 'reports'));
    }

    public function kknSummary(KknGroup $group)
    {
        $group->load(['village.profile', 'supervisor', 'leader', 'members', 'programs.tasks', 'umkms.products', 'tourismPlaces', 'documents', 'impactMetrics']);
        $village = $group->village;
        $progress = $this->progressService->calculateProgress($group);
        $impact = $this->impactService->getVillageImpact($village);

        return view('reports.kkn_summary', compact('group', 'village', 'progress', 'impact'));
    }

    public function villageProfile(KknGroup $group)
    {
        $village = $group->village->load(['profile', 'facilities', 'publishedUmkms', 'publishedTourismPlaces']);
        return view('reports.village_profile', compact('group', 'village'));
    }

    public function impactReport(KknGroup $group)
    {
        $village = $group->village;
        $impact = $this->impactService->getVillageImpact($village);
        return view('reports.impact_report', compact('group', 'village', 'impact'));
    }
}
