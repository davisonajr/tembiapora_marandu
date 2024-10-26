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
use Illuminate\Support\Carbon;

class FetchNews implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $country;
    protected $url;

    public function __construct(Country $country, $url)
    {
        $this->country = $country;
        $this->url = $url;
    }

    public function handle()
    {
        $feed = new SimplePie();
        $feed->set_feed_url($this->url);
        $feed->enable_cache(false);
        $feed->init();
        $feed->handle_content_type();

        foreach ($feed->get_items() as $item) {
            $feedId = $item->get_id();

            if (News::where('feed_id', $feedId)->exists()) {
                continue;
            }

            $publishedAt = Carbon::createFromFormat('d F Y, g:i a', $item->get_gmdate());
            $revisedAt = $item->get_updated_gmdate() ? Carbon::createFromFormat('d F Y, g:i a', $item->get_updated_gmdate()) : null;
            $text = htmlspecialchars($item->get_description() ?: $item->get_content());
            $title = htmlspecialchars($item->get_title());

            $lang = $this->country->get_lang();

            $news = News::create([
                'feed_id' => $feedId,
                'country_id' => $this->country->id,
                'title_'.$lang => $title,
                'text_'.$lang  => $text,
                'link' => $item->get_link(),
                'source' => $item->get_source(),
                'author' => $item->get_author() ? $item->get_author()->get_name() : 'Desconhecido',
                'published_at' => $publishedAt,
                'revised_at' => $revisedAt,
            ]);

            // TranslateNews::dispatch($news)->delay(now()->addMinutes(1));
        }
    }
}
