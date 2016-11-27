<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Church extends Model
{
    protected $table = "churches";

    public function camper()
    {
        return $this->belongsTo(Camper::class);
    }
}
