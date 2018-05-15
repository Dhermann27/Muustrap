<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Yearattending extends Model
{
    protected $table = "yearsattending";
    protected $fillable = ['camperid', 'year', 'roomid', 'programid', 'days', 'nametag'];

    public function camper()
    {
        return $this->hasOne(Camper::class, 'id', 'camperid');
    }

    public function getIsFirsttimeAttribute()
    {
        return DB::select(DB::raw("(SELECT COUNT(*) FROM yearsattending WHERE camperid=" . $this->id . " AND year!=getcurrentyear())"));
    }

    public function room()
    {
        return $this->hasOne(Room::class, 'id', 'roomid');
    }

    public function scholarship()
    {
        return $this->belongsTo(Scholarship::class);
    }

    public function thisyear_camper()
    {
        return $this->hasOne(Thisyear_Camper::class, 'id', 'camperid');
    }

    public function positions()
    {
        return $this->hasMany(Yearattending__Staff::class, 'yearattendingid', 'id');
    }

    public function volunteers()
    {
        return $this->hasMany(Yearattending__Volunteer::class, 'yearattendingid', 'id');
    }

    public function workshops()
    {
        return $this->hasMany(Yearattending__Workshop::class, 'yearattendingid', 'id');
    }

    public function getPronounValueAttribute()
    {
        return $this->getPronounAttribute() == '2' ? $this->camper->pronoun->name : "";
    }

    public function getPronounAttribute()
    {
        return substr($this->nametag, 0, 1);
    }

    public function getNameValueAttribute()
    {
        switch ($this->getNameAttribute()) {
            case "1":
            case "4":
                return $this->camper->firstname;
                break;
            default:
                return $this->camper->firstname . " " . $this->camper->lastname;

        }
    }

    public function getNameAttribute()
    {
        return substr($this->nametag, 1, 1);
    }

    public function getSurnameValueAttribute()
    {
        switch ($this->getNameAttribute()) {
            case "1":
                return $this->camper->lastname;
                break;
            case "3":
                return $this->thisyear_camper->family->family_name;
                break;
            default:
                return "";
        }
    }

    public function getLine1ValueAttribute()
    {
        return $this->getLine($this->getLine1Attribute());
    }

    private function getLine($i)
    {
        switch ($i) {
            case "1":
                return $this->camper->church->name;
                break;
            case "2":
                return $this->camper->family->city . ", " . $this->camper->family->statecd;
                break;
            case "3":
                return $this->positions->first()->staffposition->name;
                break;
            case "4":
                return "First-time Camper";
                break;
            default:
                return "";
        }
    }

    public function getLine1Attribute()
    {
        return substr($this->nametag, 3, 1);
    }

    public function getNamesizeAttribute()
    {
        return substr($this->nametag, 2, 1);
    }

    public function getLine2ValueAttribute()
    {
        return $this->getLine($this->getLine2Attribute());
    }

    public function getLine2Attribute()
    {
        return substr($this->nametag, 4, 1);
    }

    public function getLine3ValueAttribute()
    {
        return $this->getLine($this->getLine3Attribute());
    }

    public function getLine3Attribute()
    {
        return substr($this->nametag, 5, 1);
    }

    public function getLine4ValueAttribute()
    {
        return $this->getLine($this->getLine4Attribute());
    }

    public function getLine4Attribute()
    {
        return substr($this->nametag, 6, 1);
    }

    public function getFontapplyAttribute()
    {
        return substr($this->nametag, 7, 1);
    }

    public function getFontValueAttribute()
    {
        switch ($this->getFontAttribute()) {
            case "2":
                return "indie";
                break;
            case "3":
                return "ftg";
                break;
            case "4":
                return "quest";
                break;
            case "5":
                return "vibes";
                break;
            case "6":
                return "bangers";
                break;
            case "7":
                return "comic";
                break;
            default:
                return "opensans";
        }
    }

    public function getFontAttribute()
    {
        return substr($this->nametag, 8, 1);
    }
}
