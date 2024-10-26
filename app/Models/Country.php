<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\WordFrequency;

class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'hl',
        'gl',
        'timezone_id'
    ];

    public function news()
    {
        return $this->hasMany(News::class);
    }

    public function wordFrequencies()
    {
        return $this->hasMany(WordFrequency::class);
    }

    public function get_lang()
    {
        return explode('-',$this->hl)[0];
    }
}
