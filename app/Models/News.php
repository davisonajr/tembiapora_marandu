<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class News extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'feed_id',
        'country_id',
        'title_es',
        'title_pt',
        'text_es',
        'text_pt',
        'link',
        'source',
        'author',
        'published_at',
        'revised_at'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    protected $dates = [
        'published_at',
        'revised_at'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($news) {
            $news->published_at = $news->published_at ? $news->published_at->setTimezone('UTC') : null;
            $news->revised_at = $news->revised_at ? $news->revised_at->setTimezone('UTC') : null;
        });
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('ai_images');
        $this->addMediaCollection('ai_speechs');
    }

    public function scopeWithoutAiImages($query)
    {
        return $query->whereDoesntHave('media', function ($query) {
            $query->where('collection_name', 'ai_images');
        });
    }

    public function scopeWithoutAiSpeechs($query)
    {
        return $query->whereDoesntHave('media', function ($query) {
            $query->where('collection_name', 'ai_speechs');
        });
    }
}
