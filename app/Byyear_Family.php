<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Byyear_Family extends Model
{
    protected $table = "byyear_families";
    protected $dates = ['created_at'];

    public function allcampers() {
        return $this->hasMany(Camper::class, 'familyid', 'id');
    }

    public function getFormattedYearsAttribute()
    {
        $years = explode(",", $this->years);
        $yearstring = "";
        sort($years);
        $i = 0;
        while ($i < count($years)) {
            if ($i != 0)
                $yearstring .= ", ";
            $rangestart = $i;
            $yearstring .= $years[$i++];
            while ($i < count($years) && $years[$i] == $years[$i - 1] + 1)
                $i++;
            if ($i > $rangestart + 1)
                $yearstring .= "&ndash;" . $years[$i - 1];
        }
        return $yearstring;
    }

}
