<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $fillable = ['link', 'blurb', 'form', 'letter'];

    public function assignments()
    {
        return $this->hasMany(Thisyear_Staff::class, 'programid', 'id');
    }

    public function participants() {
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
}
