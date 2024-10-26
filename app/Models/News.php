<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = [
        'country_id', 'title_es', 'title_pt', 'text_es', 'text_pt', 'link', 'source', 'author', 'published_at', 'revised_at'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
