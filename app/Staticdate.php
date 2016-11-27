<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Staticdate extends Model
{
    protected $primaryKey = "day";
    public $timestamps = false;
}
