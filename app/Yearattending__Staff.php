<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Yearattending__Staff extends Model
{
    protected $table = "yearattending__staff";
    protected $fillable = ['yearattendingid', 'staffpositionid', 'is_eaf_paid'];

    public function yearattending()
    {
        return $this->hasOne(Yearattending::class, 'id', 'yearattendingid');
    }

    public function staffposition() {
        return $this->hasOne(Staffposition::class, 'id', 'staffpositionid');
    }
}
