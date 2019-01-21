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
            $table->integer('min_occupancy');
            $table->integer('max_occupancy');
            $table->double('rate');
            $table->integer('start_year');
            $table->integer('end_year');
            $table->timestamps();
        });
        DB::update('ALTER TABLE rates AUTO_INCREMENT = 1000');

        DB::unprepared("CREATE FUNCTION getrate(mycamperid INT, myyear YEAR)
                          RETURNS FLOAT DETERMINISTIC
                          BEGIN
                            DECLARE age, occupants, days, staff, program INT DEFAULT 0;
                            SELECT
                              getage(c.birthdate, myyear),
                              COUNT(*),
                              MAX(ya.days),
                              IF(MAX(ysp.staffpositionid) > 0, 1, 0),
                              MAX(ya.programid)
                            INTO age, occupants, days, staff, program
                            FROM (campers c, yearsattending ya, yearsattending yap, campers cp)
                              LEFT JOIN yearattending__staff ysp
                                ON ysp.yearattendingid = ya.id AND ysp.staffpositionid IN (1023, 1025)
                            WHERE c.id = mycamperid AND c.id = ya.camperid AND ya.year = myyear AND ya.roomid = yap.roomid
                                  AND ya.year = yap.year AND yap.camperid = cp.id;
                            IF staff = 1
                            THEN
                              RETURN days * 58;
                            -- DAH Meyer/Burt Staff Housing Rate $58.00/night
                            ELSE
                              RETURN (SELECT IFNULL(hr.rate * days, 0)
                                      FROM yearsattending ya, rooms r, rates hr
                                      WHERE ya.camperid = mycamperid AND ya.year = myyear AND r.id = ya.roomid AND
                                            r.buildingid = hr.buildingid AND hr.programid = program AND
                                            occupants >= hr.min_occupancy AND occupants <= hr.max_occupancy AND
                                            myyear >= hr.start_year AND myyear <= hr.end_year);
                            END IF;
                          END;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP FUNCTION IF EXISTS getrate;');
        Schema::dropIfExists('rates');
    }
}
