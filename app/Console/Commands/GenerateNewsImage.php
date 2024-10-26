<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\News;
use App\Services\ImageGenerationService;
use Illuminate\Support\Facades\Storage;

class GenerateNewsImage extends Command
{
    protected $signature = 'news:generate-image {newsId}';
    protected $description = 'Generate an image for a news item by its ID and save it using Media Library';

    public function handle()
    {
        $newsId = $this->argument('newsId');
        $news = News::find($newsId);

        if (!$news) {
            $this->error("News item with ID {$newsId} not found.");
            return;
        }

        $prompt = $news->title_pt ?: $news->title_es ?: $news->title_en;
        dd($prompt);
        $imageContent = ImageGenerationService::generateImage($news, $prompt);

        if ($imageContent) {
            $imagePath = 'ai_images/' . uniqid() . '.png';
            Storage::disk('local')->put($imagePath,$imageContent);
            $news->addMedia(storage_path('app/private/' . $imagePath))->toMediaCollection('ai_images');

            $this->info("Image generated and saved for news item with ID {$newsId}.");
        } else {
            $this->error("Failed to generate image for news item with ID {$newsId}.");
        }
    }
}
