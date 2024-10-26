<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Models\News;

class ImageGenerationService
{
    const apiUrl = 'https://image.pollinations.ai/prompt/';
    const defaultModel = '';
    const defaultSeed = 10;
    const defaultWidth = 1920;
    const defaultHeight = 1080;
    const defaultNoLogo = true;

    public static function generateImage($prompt, $model = null, $seed = null, $width = null, $height = null, $noLogo = null)
    {
        $model = $model ?? self::defaultModel;
        $seed = $seed ?? self::defaultSeed;
        $width = $width ?? self::defaultWidth;
        $height = $height ?? self::defaultHeight;
        $noLogo = $noLogo ?? self::defaultNoLogo;

        $url = self::apiUrl . urlencode($prompt) . "?model={$model}&seed={$seed}&width={$width}&height={$height}&nologo={$noLogo}";

        $response = Http::get($url);

        if ($response->successful()) {
            $imageContent = $response->body();

            return $imageContent;
        }

        return null;
    }
}