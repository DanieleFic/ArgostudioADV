<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    //

    protected $fillable = [
        'text',
        'tipes',
        'url',
        'start_time',
        'end_time',
        'note',
        'active'
    ];
    public function post()
    {
        return $this->belongsTo(User::class);
    }
}
