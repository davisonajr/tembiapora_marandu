<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Country;
use App\Models\News;
use App\Jobs\FetchNews;
use Illuminate\Support\Carbon;
use SimplePie\SimplePie;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FetchNewsTest extends TestCase
{
    use RefreshDatabase;

    public function testFetchNewsJob()
    {
        $country = Country::factory()->create([
            'gl' => 'BR',
            'hl' => 'pt-BR',
        ]);

        $url = "https://news.google.com/rss/search?q=politics&hl={$country->hl}&gl={$country->gl}";
        $this->assertDatabaseEmpty('news');

        $job = new FetchNews($country, $url);
        $job->handle();

        $this->assertDatabaseHas('news');
    }
}