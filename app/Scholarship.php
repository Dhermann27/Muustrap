<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Scholarship extends Model
{
    public function yearattending()
    {
        return $this->belongsTo(Yearattending::class);
    }
}
