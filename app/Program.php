<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    public function rate()
    {
        return $this->belongsTo(Rate::class);
    }

    public function staffposition()
    {
        return $this->belongsTo(Staffposition::class);
    }
}
