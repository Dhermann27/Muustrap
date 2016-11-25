<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('buildingid')->unsigned();
            $table->foreign('buildingid')->references('id')->on('buildings');
            $table->integer('programid')->unsigned();
            $table->foreign('programid')->references('id')->on('programs');
            $table->integer('occ_min_adult');
            $table->integer('occ_max_adult');
            $table->tinyInteger('is_children');
            $table->double('rate');
            $table->integer('start_year');
            $table->integer('end_year');
            $table->timestamps();
        });

        DB::unprepared('CREATE FUNCTION getrate (camperid INT, year INT) RETURNS FLOAT DETERMINISTIC BEGIN
            DECLARE age, adults, children, days, staff, programid INT DEFAULT 0;
            SELECT getage(c.birthdate, year), SUM(IF(getage(cp.birthdate, year)>17,1,0)), SUM(IF(getage(cp.birthdate, year)<=17,1,0)), ya.days, IF(ysp.staffpositionid>0,1,0), getprogramid(camperid, year)
   		        INTO age, adults, children, days, staff, programid 
   		        FROM (campers c, yearsattending ya, yearsattending yap, campers cp)
   		        LEFT JOIN yearsattending__staff ysp
   			        ON ysp.yearsattendingid=ya.id AND ysp.staffpositionid IN (getstaffpositionid(\'Sr. High Staff\'),getstaffpositionid(\'Jr. High Staff\'))
   		        WHERE c.id=camperid AND c.id=ya.camperid AND ya.year=year AND ya.roomid=yap.roomid AND ya.year=yap.year AND yap.camperid=cp.id;
            IF staff=1 THEN
                RETURN days * 58; -- DAH Meyer/Burt Staff Housing Rate $58.00/night
	        ELSE
		        RETURN (SELECT FORMAT(IF(age>5, IFNULL(hr.amount*days,0), 0),2) 
                    FROM yearsattending ya, rooms r, rates hr 
                    WHERE ya.camperid=camperid AND ya.year=year AND r.id=ya.roomid AND r.buildingid=hr.buildingid AND hr.programid=programid AND 
              	        (hr.occ_min_adult<=adults AND hr.occ_max_adult>=adults) AND hr.is_children=IF(children>0,1,0) AND year>=hr.start_year AND year<=hr.end_year);
            END IF;
        END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP FUNCTION IF EXISTS getrate');
        Schema::dropIfExists('rates');
    }
}
