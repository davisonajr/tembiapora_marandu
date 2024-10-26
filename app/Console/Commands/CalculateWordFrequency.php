<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\News;
use App\Services\TextAnalysisService;
use App\Models\WordFrequency;
use App\Models\Country;
use Carbon\Carbon;

class CalculateWordFrequency extends Command
{
    protected $signature = 'news:calculate-word-frequency {date?}';
    protected $description = 'Calculate the relative frequency of words for each country on a given date';

    public function handle()
    {
        $date = $this->argument('date') ? Carbon::parse($this->argument('date')) : Carbon::today();

        foreach (Country::all() as $country) {
            $newsItems = News::where('country_id', $country->id)
                ->whereDate('published_at', $date)
                ->get();

            if ($newsItems->isEmpty()) {
                continue;
            }

            $textAnalysisService = new TextAnalysisService();
            $text = '';
            foreach ($newsItems as $newsItem) {
                $text .= $newsItem->title_pt
                    ?: $newsItem->title_es
                    ?: $newsItem->title_en;

                if (!$text) {
                    continue;
                }
                $text .= ' ';
            }

            $wordFrequency = $textAnalysisService->calculateWordFrequency($text, $country->gl == 'BR' ? 'pt' : 'es');

            // Verificar se o registro já existe
            $wordFrequencyRecord = WordFrequency::where('country_id', $country->id)
                ->where('date', $date)
                ->first();

            if ($wordFrequencyRecord) {
                // Atualizar o registro existente
                $wordFrequencyRecord->update([
                    'frequencies' => $wordFrequency,
                ]);
                $this->info("Word frequency updated for country: {$country->gl}");
            } else {
                // Criar um novo registro
                WordFrequency::create([
                    'country_id' => $country->id,
                    'date' => $date,
                    'frequencies' => $wordFrequency,
                ]);
                $this->info("Word frequency created for country: {$country->gl}");
            }
        }

        $this->info("Word frequency calculation completed for date: {$date->toDateString()}");
    }
}
