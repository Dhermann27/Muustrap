<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    public function building()
    {
        return $this->hasOne(Building::class, 'id', 'buildingid');
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

    public function getOccupantsAttribute() {

        $campers = \App\Thisyear_Camper::where('roomid', $this->id)->orderBy('lastname', 'birthdate')->get();
        if(count($campers) > 0) {
            $str = "<br /><i>Current Occupants</i>:";
            foreach ($campers as $camper) {
                $str .= '<br />' . $camper->firstname . ' ' . $camper->lastname;
            }
            return $str;
        } else {
            return null;
        }
    }

    public function getRoomNameAttribute()
    {
        $roomname = $this->building->name;
        $roomname .= $this->buildingid < 1007 ? ', Room ' . $this->room_number : '';
        if (isset($this->connected_with)) {
            $connectingroom = \App\Room::findOrFail($this->connected_with);
            $roomname .= ($this->buildingid == 1000 ?
                '<br /><i>Double Privacy Door with Room ' . $connectingroom->room_number . '</i>' :
                '<br /><i>Shares common area with Room ' . $connectingroom->room_number . '</i>');
        }
        return $roomname;
    }

    public function connected_with()
    {
        return $this->hasOne(Room::class, 'id', 'connected_with');
    }
}
