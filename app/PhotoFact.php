<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhotoFact extends Model
{
    protected $fillable = [
        'photoId', 'album_id', 'user_id', 'comment', 'unix_sec', 'latitude', 'longitude', 'distance'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
