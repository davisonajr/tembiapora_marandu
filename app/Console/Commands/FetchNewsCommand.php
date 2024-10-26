<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Country;
use App\Jobs\FetchNews;

class FetchNewsCommand extends Command
{
    protected $signature = 'news:fetch';
    protected $description = 'Fetch news from Google News RSS for each country';

    public function handle()
    {
        $countries = Country::all();

        foreach ($countries as $country) {
            FetchNews::dispatch($country)->delay(now()->addMinutes(1));
        }

        $this->info('Fetching news jobs dispatched successfully.');
    }
}
