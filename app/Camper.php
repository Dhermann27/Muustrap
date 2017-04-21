<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Camper extends Model
{
    protected $fillable = ['familyid', 'sexcd', 'firstname', 'lastname', 'email', 'phonenbr', 'birthdate',
        'gradeoffset', 'sponsor', 'is_handicap', 'foodoptionid', 'churchid', 'updated_at'];

    public function charge()
    {
        return $this->belongsTo(Charge::class);
    }

    public function church()
    {
        return $this->hasOne(Church::class, 'id', 'churchid');
    }

    public function family()
    {
        return $this->belongsTo(Family::class, 'familyid');
    }

    public function gencharge()
    {
        return $this->belongsTo(Gencharge::class);
    }

    public function foodoption()
    {
        return $this->hasOne(Foodoption::class, 'id', 'foodoptionid');
    }

    public function oldgencharge()
    {
        return $this->belongsTo(Oldgencharge::class);
    }

    public function pronoun()
    {
        return $this->hasOne(Pronoun::class, 'id', 'pronounid');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'email', 'email');
    }

    public function yearattending()
    {
        return $this->belongsTo(Yearattending::class);
    }

    public function getFormattedPhoneAttribute()
    {
        if (preg_match('/^(\d{3})(\d{3})(\d{4})$/', $this->phonenbr, $matches)) {
            $result = $matches[1] . '-' . $matches[2] . '-' . $matches[3];
            return $result;
        }
        return "";
    }

    public function getAgeAttribute()
    {
        return DB::table('users')->value(DB::raw("getage('" . $this->birthdate . "',getcurrentyear())"));
    }

    public function getGradeAttribute()
    {
        return DB::table('users')->value(DB::raw("getage('" . $this->birthdate . "',getcurrentyear())+" . $this->gradeoffset)) ;
    }

    public function getLoggedInAttribute()
    {
        return $this->email == Auth::user()->email;
    }

    public function getYearattendingidAttribute()
    {
        $ya = \App\Yearattending::where(['camperid' => $this->id, 'year' => DB::raw('getcurrentyear()')])->first();
        if ($ya) {
            return $ya->id;
        } else {
            if ($this->updatedRecently()) {
                return 0;
            } else {
                return 1;
            }
        }
    }

    private function updatedRecently()
    {
        $open = new \DateTime(\App\Year::where('year', DB::raw('getcurrentyear()-1'))->first()->start_date);
        return $this->updated_at !== null ? new \DateTime($this->updated_at) > $open : 0;
    }

}
