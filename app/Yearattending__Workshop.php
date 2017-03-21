<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Yearattending__Workshop extends Model
{
    protected $table = "yearattending__workshop";
    protected $fillable = ['yearattendingid', 'workshopid'];

    public function yearattending()
    {
        return $this->hasOne(Yearattending::class, 'id', 'yearattendingid')->where('year', DB::raw('getcurrentyear()'));
    }

    public function workshop()
    {
        return $this->hasOne(Workshop::class, 'id', 'workshopid');
    }
}
