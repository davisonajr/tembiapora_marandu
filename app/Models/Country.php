<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = [
        'hl',
        'gl',
        'timezone_id'
    ];

    public function news()
    {
        return $this->hasMany(News::class);
    }
}
