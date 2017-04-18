<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Yearattending__Volunteer extends Model
{
    protected $table = "yearattending__volunteer";
    protected $fillable = ['yearattendingid', 'volunteerpositionid'];

    public function yearattending()
    {
        return $this->hasOne(Yearattending::class, 'id', 'yearattendingid');
    }

    public function volunteerposition() {
        return $this->hasOne(Volunteerposition::class, 'id', 'volunteerpositionid');
    }
}
