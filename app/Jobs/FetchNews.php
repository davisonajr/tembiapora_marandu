<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Country;
use App\Models\News;
use SimplePie\SimplePie;

class FetchNews implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $country;

    public function __construct(Country $country)
    {
        $this->country = $country;
    }

    public function handle()
    {
        $url = "https://news.google.com/rss?hl={$this->country->hl}&gl={$this->country->gl}";

        $feed = new SimplePie();
        $feed->set_feed_url($url);
        $feed->enable_cache(false);
        $feed->init();
        $feed->handle_content_type();

        foreach ($feed->get_items() as $item) {
            News::create([
                'country_id' => $this->country->id,
                'title_es' => $item->get_title(),
                'title_pt' => $item->get_title(),
                'text_es' => $item->get_description() ?: $item->get_content(),
                'text_pt' => $item->get_description() ?: $item->get_content(),
                'link' => $item->get_link(),
                'source' => $item->get_feed()->get_title(),
                'author' => $item->get_author() ? $item->get_author()->get_name() : 'Desconhecido',
                'published_at' => $item->get_date('Y-m-d H:i:s'),
                'revised_at' => now(),
            ]);
        }
    }
}
