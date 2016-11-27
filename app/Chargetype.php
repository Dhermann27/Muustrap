<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chargetype extends Model
{
    public $timestamps = false;

    public function charge()
    {
        return $this->belongsTo(Charge::class);
    }

    public function gencharge()
    {
        return $this->belongsTo(Gencharge::class);
    }

    public function oldgencharge()
    {
        return $this->belongsTo(Oldgencharge::class);
    }
}
