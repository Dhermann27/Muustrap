<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Year extends Model
{
    protected $primaryKey = "year";
    public $timestamps = false;

    public function rates($year) {
        return \App\Rate::where('start_year', '<=', $this->year)->where('end_year', '>=', $this->year)->get();
    }
}
