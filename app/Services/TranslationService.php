<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TranslationService
{
    protected $baseUrl = 'https://libretranslate.com/translate';

    public function translate($text, $source, $target)
    {
        $response = Http::post($this->baseUrl, [
            'q' => $text,
            'source' => $source,
            'target' => $target,
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        return null;
    }
}
