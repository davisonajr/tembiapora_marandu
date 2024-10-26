<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TextGenerationService
{
    const apiUrl = 'https://text.pollinations.ai/';
    const defaultModel = 'searchgpt';
    const defaultSeed = 10;
    const defaultJson = true;

    public static function generateText($prompt, $model = null, $seed = null, $json = null, $system = null)
    {
        $model = $model ?? self::defaultModel;
        $seed = $seed ?? self::defaultSeed;
        $json = $json ?? self::defaultJson;

        $url = self::apiUrl . urlencode($prompt) . "?model={$model}&seed={$seed}&json={$json}";

        $response = Http::get($url);

        if ($response->successful()) {
            return $response->json();
        }

        return null;
    }
}