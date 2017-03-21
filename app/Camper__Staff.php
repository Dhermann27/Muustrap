<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Camper__Staff extends Model
{
    protected $table = "camper__staff";
    protected $fillable = ['yearattendingid', 'staffpositionid'];

    public function yearattending()
    {
        return $this->hasOne(Yearattending::class, 'id', 'yearattendingid');
    }

    public function staffposition() {
        return $this->hasOne(Staffposition::class, 'id', 'staffpositionid');
    }
}
