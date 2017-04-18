<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Yearattending extends Model
{
    protected $table = "yearsattending";
    protected $fillable = ['camperid', 'year', 'roomid', 'days'];

    public function camper()
    {
        return $this->hasOne(Camper::class, 'id', 'camperid');
    }

    public function room()
    {
        return $this->hasOne(Room::class);
    }

    public function scholarship()
    {
        return $this->belongsTo(Scholarship::class);
    }

    public function volunteers()
    {
        return $this->hasMany(Yearattending__Volunteer::class, 'yearattendingid', 'id');
    }

    public function workshops()
    {
        return $this->hasMany(Yearattending__Workshop::class, 'yearattendingid', 'id');
    }
}
