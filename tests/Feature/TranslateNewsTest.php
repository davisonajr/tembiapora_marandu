<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Country;
use App\Models\News;
use App\Jobs\TranslateNews;

class TranslateNewsTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_translation(): void
    {
        $BR = Country::factory()->create([
            'gl' => 'BR',
            'hl' => 'pt-BR',
        ]);

        $news = new News();

        $news->fill([
            'feed_id' => '12345',
            'country_id' => $BR->id,
            'title_pt' => 'Título em português',
            'text_pt' => 'Texto em português para testar a capacidade de tradução. Vamos ver como vai ficar!'
        ]);

        $news->save();

        $this->assertFalse(!!$news->title_es);
        $this->assertFalse(!!$news->text_es);

        $translator = new TranslateNews($news);
        $translator->handle();

        $news->refresh();
        $this->assertTrue(!!$news->title_es);
        $this->assertTrue(!!$news->text_es);

    }
}
