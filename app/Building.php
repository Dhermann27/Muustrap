<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    public $timestamps = false;

    public function rate()
    {
        return $this->belongsTo(Rate::class);
    }

    public function room()
    {
        return $this->belongsTo(Rate::class);
    }
}
