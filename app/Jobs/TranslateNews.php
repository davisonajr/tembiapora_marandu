<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\News;
use App\Services\TranslationService;

class TranslateNews implements ShouldQueue
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
        match ($this->news->country->get_lang()) {
            'pt' => $this->fromPT(),
            'es' => $this->fromES(),
            'en' => $this->fromES()
        };
        $this->news->save();
    }

    public function fromPT() {
        $title = $this->news->title_pt;
        $text = $this->news->text_pt;
        $trans = new TranslationService();

        $title_es = $trans->translate('pt', 'es', $title);
        $title_en = $trans->translate('pt', 'en', $title);
        $text_es = $trans->translate('pt', 'es', $text);
        $text_en = $trans->translate('pt', 'en', $text);

        $this->news->fill([
            'title_es' => $title_es,
            'title_en' => $title_en,
            'text_es' => $text_es,
            'text_en' => $text_en,
        ]);
    }
    public function fromES() {
        $title = $this->news->title_pt;
        $text = $this->news->text_pt;
        $trans = new TranslationService();

        $title_pt = $trans->translate('es', 'pt', $title);
        $title_en = $trans->translate('es', 'en', $title);
        $text_pt = $trans->translate('es', 'pt', $text);
        $text_en = $trans->translate('es', 'en', $text);

        $this->news->fill([
            'title_pt' => $title_pt,
            'title_en' => $title_en,
            'text_pt' => $text_pt,
            'text_en' => $text_en,
        ]);
    }
    public function fromEN() {
        $title = $this->news->title_pt;
        $text = $this->news->text_pt;
        $trans = new TranslationService();

        $title_pt = $trans->translate('en', 'pt', $title);
        $title_es = $trans->translate('en', 'es', $title);
        $text_pt = $trans->translate('en', 'pt', $text);
        $text_es = $trans->translate('en', 'es', $text);

        $this->news->fill([
            'title_pt' => $title_pt,
            'title_es' => $title_es,
            'text_pt' => $text_pt,
            'text_es' => $text_es,
        ]);
    }
}
