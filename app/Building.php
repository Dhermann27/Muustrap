<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    public $timestamps = false;

    public function rooms()
    {
        return $this->hasMany(Room::class, 'buildingid', 'id');
    }
}
