<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\News;
use App\Services\ImageGenerationService;
use Illuminate\Support\Facades\Storage;

class CreateAIImage implements ShouldQueue
{
    use Queueable;

    protected $news;
    /**
     * Create a new job instance.
     */
    public function __construct(News $news)
    {
        $this->news = $news;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $prompt = $this->news->title_pt ?: $this->news->title_es ?: $this->news->title_en;

        $imageContent = ImageGenerationService::generateImage($prompt);

        if ($imageContent) {
            $imagePath = 'ai_images/' . uniqid() . '.png';
            Storage::disk('local')->put($imagePath,$imageContent);
            $this->news->addMedia(storage_path('app/private/' . $imagePath))->toMediaCollection('ai_images');        
        }
    }
}
