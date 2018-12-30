<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Nicolaslopezj\Searchable\SearchableTrait;

class Camper extends Model
{
    use SearchableTrait;

    protected $fillable = ['familyid', 'sexcd', 'firstname', 'lastname', 'email', 'phonenbr', 'birthdate',
        'sponsor', 'is_handicap', 'foodoptionid', 'churchid', 'updated_at'];

    protected $searchable = [
        'columns' => [
            'campers.firstname' => 10,
            'campers.lastname' => 10,
            'campers.email' => 5
        ],
        'joins' => [
            'families' => ['campers.familyid', 'families.id']
        ]
    ];

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

    public function getLastProgramidAttribute()
    {
        $ya = \App\Yearattending::where('camperid', $this->id)->orderBy('year', 'desc')->first();
        return $ya ? ($ya->programid == '1006' ? '1009' : $ya->programid) : null;
    }

    public function getFormattedPhoneAttribute()
    {
        if (preg_match('/^(\d{3})(\d{3})(\d{4})$/', $this->phonenbr, $matches)) {
            $result = $matches[1] . '-' . $matches[2] . '-' . $matches[3];
            return $result;
        }
        return "";
    }

    public function getBirthdayAttribute()
    {
        return substr($this->birthdate, 5);
    }

    public function getAgeAttribute()
    {
        if ($this->birtdate != '') {
            return DB::table('users')->value(DB::raw("getage('" . $this->birthdate . "',getcurrentyear())"));
        } else {
            return "";
        }
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
