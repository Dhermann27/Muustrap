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
                $parents = $this->family->campers->where('age', '>', 17)->sortBy('birthdate');
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

    public function getEachCalendarAttribute() {
        $cal = explode(';', $this->program->calendar);
        if(count($cal) == 3) {
            $age = $this->birthdate->diffInYears(Carbon::now());
            if($age < 8) {
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
}
