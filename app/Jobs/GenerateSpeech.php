<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\News;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Services\SpeechGenerationService;

class GenerateSpeech implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $news;

    public function __construct(News $news)
    {
        $this->news = $news;
    }

    public function handle()
    {
        $speech = $this->news->ai_comment;

        if (!$speech) {
            return;
        }

        $tempFilePath = SpeechGenerationService::generate(
            $speech,
            $this->news->country->gl
        );

        if (File::exists($tempFilePath)) {

            $this->news->addMedia($tempFilePath)->toMediaCollection('ai_speechs');

            File::delete($tempFilePath);
        }
    }
}
