<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Staffposition extends Model
{
    public function compensationlevel()
    {
        return $this->hasOne(Compensationlevel::class);
    }

    public function program()
    {
        return $this->hasOne(Program::class);
    }
}


