<?php

namespace App\Services\Ai;

use Illuminate\Support\Facades\Http;

class GeminiAiProvider implements AiProviderInterface
{
    protected ?string $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.gemini.key', env('GEMINI_API_KEY'));
    }

    public function generate(string $prompt, array $context = []): string
    {
        if (empty($this->apiKey)) {
            // Fallback cleanly to mock provider if no API key configured
            return (new MockAiProvider())->generate($prompt, $context);
        }

        try {
            $response = Http::timeout(10)->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key={$this->apiKey}", [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['candidates'][0]['content']['parts'][0]['text'] ?? (new MockAiProvider())->generate($prompt, $context);
            }
        } catch (\Throwable $e) {
            // Silent fallback to mock provider
        }

        return (new MockAiProvider())->generate($prompt, $context);
    }
}
