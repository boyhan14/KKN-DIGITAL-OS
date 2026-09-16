<?php

namespace App\Services;

use App\Services\Ai\AiProviderInterface;
use App\Services\Ai\MockAiProvider;
use App\Services\Ai\GeminiAiProvider;

class AiContentService
{
    protected AiProviderInterface $provider;

    public function __construct()
    {
        $driver = config('services.ai.driver', env('AI_DRIVER', 'mock'));

        $this->provider = match ($driver) {
            'gemini' => new GeminiAiProvider(),
            default => new MockAiProvider(),
        };
    }

    public function draftVillageIntroduction(string $villageName, ?string $history = null, ?string $potential = null): string
    {
        $prompt = "Buatkan narasi pengantar profil resmi untuk Desa {$villageName}, dengan mempertimbangkan sejarah: {$history} dan potensi: {$potential}. Gunakan bahasa Indonesia yang santun, profesional, dan membanggakan potensi lokal.";
        return $this->provider->generate($prompt, ['type' => 'village_profile', 'village_name' => $villageName]);
    }

    public function draftProgramDescription(string $title, string $category, ?string $objective = null): string
    {
        $prompt = "Buatkan deskripsi pelaksanaan dan tujuan program kerja KKN '{$title}' dalam bidang {$category}. Tujuan utama: {$objective}.";
        return $this->provider->generate($prompt, ['type' => 'program_description', 'title' => $title]);
    }

    public function draftImpactNarrative(array $stats): string
    {
        $prompt = "Buatkan ringkasan narasi capaian dampak program KKN berdasarkan statistik berikut: " . json_encode($stats);
        return $this->provider->generate($prompt, ['type' => 'impact_summary', 'stats' => $stats]);
    }
}
