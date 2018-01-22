<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medicalresponse extends Model
{
    protected $fillable = ['yearattendingid', 'parent_name', 'youth_sponsor', 'mobile_phone', 'concerns', 'doctor_name',
        'doctor_nbr', 'is_insured', 'holder_name', 'holder_birthday', 'carrier_name', 'carrier_nbr', 'carrier_id',
        'carrier_group', 'is_epilepsy', 'is_diabetes', 'is_add', 'is_adhd'];

    public function yearattending() {
        $this->hasOne(Yearattending::class, 'id', 'yearattendingid');
    }
}
