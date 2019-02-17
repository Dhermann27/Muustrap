<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    protected $year;

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $this->year = \App\Year::where('is_current', '1')->first();
        \View::share('year', $this->year);
    }

    public function getSteps($id = null) {
        if(preg_match('/\/(c|f)\/(\d+)$/', $_SERVER['REQUEST_URI'], $matches)) {
            $id = $matches[1] == 'c' ? $matches[2] : 0;
        } else {
            $id = isset($id) ? $id : Auth::user()->camper->id;
        }
        return DB::select('SELECT IF(c.familyid!=0,1,0) household, IF(ya.id IS NOT NULL,1,0) campers, 
          IF(ya.id IS NOT NULL AND SUM(th.amount)<=0,1,0) payment, IF(yw.workshopid IS NOT NULL,1,0) workshops, 
          IF(ya.roomid IS NOT NULL,1,0) room, IF(ya.nametag!=\'222215521\',1,0) nametag, 
          IF(mr.id IS NOT NULL,1,0) medical FROM campers c
          LEFT OUTER JOIN yearsattending ya ON c.id=ya.camperid AND ya.year=?
          LEFT OUTER JOIN thisyear_charges th ON c.familyid=th.familyid
          LEFT OUTER JOIN yearattending__workshop yw ON ya.id=yw.yearattendingid
          LEFT OUTER JOIN medicalresponses mr ON ya.id=mr.yearattendingid
          WHERE c.id=?', [$this->year->year, $id]);
    }
}
