<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    public function building()
    {
        return $this->hasOne(Building::class, 'id', 'buildingid');
    }

    public function occupants() {
        return $this->hasMany(Thisyear_Camper::class, 'roomid', 'id');
    }

    public function workshop()
    {
        return $this->belongsTo(Workshop::class);
    }

    public function yearattending()
    {
        return $this->belongsTo(Yearattending::class);
    }

    public function getOccupantCountAttribute() {
        return \App\Thisyear_Camper::where('roomid', $this->id)->count();
    }

    public function connected_with()
    {
        return $this->hasOne(Room::class, 'id', 'connected_with');
    }
}
