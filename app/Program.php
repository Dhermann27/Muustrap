<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Program extends Model
{
    protected $fillable = ['link', 'blurb', 'form', 'letter'];

    public function assignments()
    {
        return $this->hasMany(Thisyear_Staff::class, 'programid', 'id');
    }

    public function participants()
    {
        return $this->hasMany(Thisyear_Camper::class, 'programid', 'id');
    }

    public function rate()
    {
        return $this->belongsTo(Rate::class);
    }

    public function staffpositions()
    {
        return $this->hasMany(Staffposition::class, 'programid', 'id');
    }

    public function getEmailsAttribute()
    {
        return DB::table('Thisyear_Camper')->where('programid', $this->id)->where('email', '!=', null)
            ->implode('email', '; ');
    }
}
