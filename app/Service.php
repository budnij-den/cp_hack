<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id', 'rule_id', 'dateToServe', 'mark'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
