<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Yearattending__Workshop extends Model
{
    protected $table = "yearattending__workshop";
    protected $fillable = ['yearattendingid', 'workshopid'];

    public function yearattending()
    {
        return $this->hasOne(Yearattending::class, 'id', 'yearattendingid');
    }

    public function workshop() {
        return $this->hasOne(Workshop::class, 'id', 'workshopid');
    }
}
