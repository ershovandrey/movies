<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $fillable = [
        'movie_id',
        'title',
        'overview',
        'vote_average',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
