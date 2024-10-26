<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WordFrequency extends Model
{
    protected $fillable = ['country_id', 'date', 'frequencies'];

    protected $casts = [
        'frequencies' => 'json',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}