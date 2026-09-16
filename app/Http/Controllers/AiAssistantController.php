<?php

namespace App\Http\Controllers;

use App\Services\AiContentService;
use Illuminate\Http\Request;

class AiAssistantController extends Controller
{
    protected AiContentService $aiService;

    public function __construct(AiContentService $aiService)
    {
        $this->aiService = $aiService;
    }

    public function draft(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:village_profile,program_description,impact_summary',
            'village_name' => 'nullable|string',
            'title' => 'nullable|string',
            'category' => 'nullable|string',
            'objective' => 'nullable|string',
            'history' => 'nullable|string',
            'stats' => 'nullable|array',
        ]);

        $text = match ($validated['type']) {
            'village_profile' => $this->aiService->draftVillageIntroduction(
                $validated['village_name'] ?? 'Desa',
                $validated['history'] ?? null
            ),
            'program_description' => $this->aiService->draftProgramDescription(
                $validated['title'] ?? 'Program Kerja',
                $validated['category'] ?? 'DIGITALISASI',
                $validated['objective'] ?? null
            ),
            'impact_summary' => $this->aiService->draftImpactNarrative($validated['stats'] ?? []),
        };

        return response()->json([
            'success' => true,
            'draft' => $text,
        ]);
    }
}
