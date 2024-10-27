<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\News;
use App\Jobs\GenerateSpeech;

class GenerateSpeechCommand extends Command
{
    protected $signature = 'news:generate-speech';
    protected $description = 'Generate speech files for news items with ai_comment';

    public function handle()
    {
        $newsItems = News::withoutAiSpeechs()->whereNotNull('ai_comment')->take(5)->get();

        foreach ($newsItems as $newsItem) {
            GenerateSpeech::dispatch($newsItem);
        }

        $this->info("Speech generation jobs dispatched for " . count($newsItems) . " news items.");
    }
}