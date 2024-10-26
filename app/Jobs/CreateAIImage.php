<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\News;

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
        $tokens = tokenize($this->news->text_pt, \TextAnalysis\Tokenizers\PennTreeBankTokenizer::class);

        $tokens = normalize_tokens($tokens);

        $sentimentScores = vader($tokens);

        
    }
}
