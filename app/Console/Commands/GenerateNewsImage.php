<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\News;
use App\Jobs\CreateAIImage;

class GenerateNewsImage extends Command
{
    protected $signature = 'news:generate-image {newsId}';
    protected $description = 'Generate an image for a news item by its ID and save it using Media Library';

    public function handle()
    {
        $newsId = $this->argument('newsId');
        
        $news = $newsId ? collect(News::find($newsId)) : News::withoutAiImages()->take(5)->get();

        if (!$news) {
            $this->error("News item with ID {$newsId} not found.");
            return;
        }

        foreach($news as $new)
        {
            CreateAIImage::dispatch($news);
            $this->info("Job programed for creatng {$new->id} image.");
        }
    }
}
