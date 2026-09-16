<?php

namespace App\Http\Controllers;

use App\Models\KknGroup;
use App\Models\ImpactMetric;
use App\Models\ActivityLog;
use App\Services\ImpactService;
use Illuminate\Http\Request;

class ImpactController extends Controller
{
    protected ImpactService $impactService;

    public function __construct(ImpactService $impactService)
    {
        $this->impactService = $impactService;
    }

    public function index(KknGroup $group)
    {
        $metrics = $group->impactMetrics()->with('program')->get();
        $impactSummary = $this->impactService->getVillageImpact($group->village);
        $programs = $group->programs;
        $isLocked = $group->status === 'COMPLETED';

        return view('impact.index', compact('group', 'metrics', 'impactSummary', 'programs', 'isLocked'));
    }

    public function store(Request $request, KknGroup $group)
    {
        if ($group->status === 'COMPLETED') {
            abort(403, 'Kelompok KKN telah selesai.');
        }

        $validated = $request->validate([
            'metric_name' => 'required|string|max:255',
            'category' => 'required|string',
            'program_id' => 'nullable|exists:programs,id',
            'baseline' => 'required|integer|min:0',
            'target' => 'required|integer|min:1',
            'achieved' => 'required|integer|min:0',
            'unit' => 'required|string|max:50',
            'description' => 'nullable|string',
        ]);

        $metric = ImpactMetric::create([
            'kkn_group_id' => $group->id,
            'village_id' => $group->village_id,
            'program_id' => $validated['program_id'] ?? null,
            'metric_name' => $validated['metric_name'],
            'category' => $validated['category'],
            'baseline' => $validated['baseline'],
            'target' => $validated['target'],
            'achieved' => $validated['achieved'],
            'unit' => $validated['unit'],
            'description' => $validated['description'] ?? null,
        ]);

        ActivityLog::create([
            'kkn_group_id' => $group->id,
            'village_id' => $group->village_id,
            'user_id' => auth()->id(),
            'action' => 'added_impact_metric',
            'description' => "Menambahkan indikator capaian/dampak: {$metric->metric_name}",
            'created_at' => now(),
        ]);

        return back()->with('success', 'Metrik dampak berhasil ditambahkan.');
    }

    public function update(Request $request, KknGroup $group, ImpactMetric $metric)
    {
        $validated = $request->validate([
            'achieved' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ]);

        $metric->update($validated);

        return back()->with('success', 'Angka capaian dampak berhasil diperbarui.');
    }

    public function destroy(KknGroup $group, ImpactMetric $metric)
    {
        $metric->delete();
        return back()->with('success', 'Metrik dampak berhasil dihapus.');
    }
}
