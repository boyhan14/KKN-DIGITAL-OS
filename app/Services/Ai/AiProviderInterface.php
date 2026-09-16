<?php

namespace App\Services\Ai;

interface AiProviderInterface
{
    /**
     * Generate content narrative based on prompt and parameters.
     */
    public function generate(string $prompt, array $context = []): string;
}
