<?php

namespace App\Console\Commands;

use App\Jobs\FetchNews;
use Illuminate\Console\Command;
use App\Models\Country;
use Carbon\Carbon;


class FetchNewsCommand extends Command
{
    const GOOGLE_NEWS_COUNTRIES = [
        'AR',
        'BO',
        'BR',
        'CL',
        'CO',
        'MX',
        'PE',
        'VE'
    ];
    protected $signature = 'news:fetch';
    protected $description = 'Fetch news from Google News RSS for each country';

    public function handle()
    {
        $countries = Country::whereIn('gl',self::GOOGLE_NEWS_COUNTRIES)->get();

        foreach ($countries as $country) {
            $now = Carbon::now();
            $yesterday = $now->copy()->subDay();
            $word = $country->gl == 'BR' ? 'povo' : 'pueblo';
            $query = $word . '+after:' . $yesterday->toDateString() . '+before:' . $now->toDateString();
            $url = "https://news.google.com/rss/?hl={$country->hl}&gl={$country->gl}";
    
            FetchNews::dispatch($country, $url)->delay(now()->addMinutes(1));
        }
        $this->info('Fetching news jobs dispatched successfully.');

    }
}
