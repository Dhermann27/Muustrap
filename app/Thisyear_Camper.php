<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Thisyear_Camper extends Model
{
    protected $table = "thisyear_campers";
    protected $dates = ['birthdate'];

    public function church()
    {
        return $this->hasOne(Church::class, 'id', 'churchid');
    }

    public function family()
    {
        return $this->hasOne(Thisyear_Family::class, 'id', 'familyid');
    }

    public function foodoption()
    {
        return $this->hasOne(Foodoption::class, 'id', 'foodoptionid');
    }

    public function program()
    {
        return $this->hasOne(Program::class, 'id', 'programid');
    }

    public function pronoun()
    {
        return $this->hasOne(Pronoun::class, 'id', 'pronounid');
    }

    public function yearattending()
    {
        return $this->hasOne(Yearattending::class, 'id', 'yearattendingid');
    }

    public function history()
    {
        return \App\Byyear_Camper::where('id', $this->id)->where('year', '>', DB::raw('getcurrentyear()-5'))->orderBy('year')->get();
    }

    public function getFormattedPhoneAttribute()
    {
        if (preg_match('/^(\d{3})(\d{3})(\d{4})$/', $this->phonenbr, $matches)) {
            $result = $matches[1] . '-' . $matches[2] . '-' . $matches[3];
            return $result;
        }
        return "";
    }

    public function getParentAttribute()
    {
        $icon = "<i class='fa fa-male'></i> ";
        if ($this->age < 18) {
            if (!empty($this->sponsor)) {
                return "<i class='fa fa-id-badge'></i> " . $this->sponsor;
            } else {
                $parents = $this->parents()->get();
                if (count($parents) == 1) {
                    return $icon . $parents->first()->firstname . " " . $parents->first()->lastname;
                } elseif (count($parents) > 1) {
                    $first = $parents->shift();
                    $second = $parents->shift();
                    if ($first->lastname == $second->lastname) {
                        return $icon . $first->firstname . " & " . $second->firstname . " " . $first->lastname;
                    } else {
                        return $icon . $first->firstname . " " . $first->lastname . " & " . $second->firstname . " " . $second->lastname;
                    }
                } else {
                    return "<i>Unsponsored Minor</i>";
                }
            }
        } else {
            return "";
        }
    }

    public function parents()
    {
        return $this->hasMany(Thisyear_Camper::class, 'familyid', 'familyid')
            ->where('age', '>', '17')->orderBy('birthdate');
    }

    public function getParentRoomAttribute()
    {

        if ($this->age < 18) {
            $parent = !empty($this->sponsor) ? \App\Thisyear_Camper::where(DB::raw('CONCAT(firstname," ",lastname)'), $this->sponsor)->first() : $this->parents()->first();
            return !empty($parent->roomid) ? $parent->buildingname . " " . $parent->room_number : "Unassigned";
        } else {
            return "";
        }
    }

    public function getParentPhoneAttribute()
    {

        if ($this->age < 18) {
            $parents = !empty($this->sponsor) ? \App\Thisyear_Camper::where(DB::raw('CONCAT(firstname," ",lastname)'), $this->sponsor)->get() : $this->parents()->get();
            foreach ($parents as $parent) {
                if (!empty($parent->phonenbr)) return $parent->formatted_phone;
            }
            return "None Given";
        } else {
            return "";
        }
    }

    public function getEachCalendarAttribute()
    {
        $cal = explode(';', $this->program->calendar);
        if (count($cal) == 3) {
            $age = $this->birthdate->diffInYears(Carbon::now());
            if ($age < 8) {
                return $cal[0];
            } elseif ($age > 9) {
                return $cal[2];
            } else {
                return $cal[1];
            }
        } else {
            return $cal[0];
        }
    }

    public function getNametagBackAttribute()
    {
        switch ($this->programid) {
            case 1001:
                return "Leader: ________________________________<br /><br />________________________________<br />________________________________<br />________________________________<br />________________________________<br />________________________________<br />________________________________";
                break;
            case 1002:
            case 1007:
                $parents = "";
                foreach ($this->family->campers()->where('age', '>', '17')->orderBy('birthdate')->get() as $parent) {
                    $parents .= "<u>" . $parent->firstname . " " . $parent->lastname . "</u><br />";
                    $parents .= "Room: " . $parent->buildingname . " " . $parent->room_number . "<br />";
                    if (count($parent->yearattending->workshops()->where('is_enrolled', '1')->get()) > 0) {
                        foreach ($parent->yearattending->workshops()->where('is_enrolled', '1')->get() as $workshop) {
                            if ($workshop->workshop->timeslotid == 1001 || $workshop->workshop->timeslotid == 1002) {
                                $parents .= $workshop->workshop->timeslot->name . " (" . $workshop->workshop->display_days . ") " . $workshop->workshop->room->room_number . "<br />";
                            }
                        }
                    }
                }
                return $parents;
                break;
            default:
                $parents = "";
                if (count($this->yearattending->workshops()->where('is_enrolled', '1')->get()) > 0) {
                    foreach ($this->yearattending->workshops()->where('is_enrolled', '1')->get() as $workshop) {
                        if ($workshop->workshop->timeslotid == 1001 || $workshop->workshop->timeslotid == 1002) {
                            $parents .= $workshop->workshop->timeslot->name . " (" . $workshop->workshop->display_days . "): " . $workshop->workshop->name . " in " . $workshop->workshop->room->room_number . "<br />";
                        }
                    }
                }
                return $parents;
                break;
        }
    }
}
