<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    public function rate()
    {
        return $this->belongsTo(Rate::class);
    }

    public function staffpositions()
    {
        return $this->hasMany(Staffposition::class, 'programid', 'id');
    }

    public function assignments()
    {
        return this->$this->hasMany(Thisyea)
    }
}
