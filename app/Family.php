<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    protected $table = "families";

    public function camper()
    {
        return $this->belongsTo(Camper::class);
    }

    public function statecode()
    {
        return $this->hasOne(Statecode::class);
    }
}
