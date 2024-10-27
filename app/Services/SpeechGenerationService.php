<?php

namespace App\Services;

class SpeechGenerationService
{
    /**
     * Generate speach.
     */
    public static function generate($speech, $gl)
    {
        $lang = $gl == "BR" 
            ? "brazil" 
            : 'spanish-latin-am'
        ;

        // Gerar o arquivo de áudio usando espeak
        $tempFilePath = storage_path('app/temp/' . uniqid() . '.wav');
        exec("espeak -w {$tempFilePath} -l {$lang} '{$speech}'");

        return $tempFilePath;
    }
}
