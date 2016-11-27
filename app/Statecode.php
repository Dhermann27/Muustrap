<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Statecode extends Model
{
    protected $primaryKey = "code";
    public $incrementing = false;
    public $timestamps = false;

    public function family()
    {
        return $this->belongsTo(Family::class);
    }
}
