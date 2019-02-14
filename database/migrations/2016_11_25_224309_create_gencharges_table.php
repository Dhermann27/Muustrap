<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGenchargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gencharges', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('camperid')->unsigned();
            $table->foreign('camperid')->references('id')->on('campers');
            $table->float('charge');
            $table->string('memo')->nullable();
            $table->integer('chargetypeid')->unsigned();
            $table->foreign('chargetypeid')->references('id')->on('chargetypes');
            $table->integer('year');
        });
        DB::update('ALTER TABLE gencharges AUTO_INCREMENT = 1000');

        DB::unprepared("CREATE DEFINER =`root`@`localhost` PROCEDURE generate_charges(myyear YEAR)
                  BEGIN
                    SET SQL_MODE = '';
                    DELETE FROM gencharges
                    WHERE year = myyear;
                    INSERT INTO gencharges (year, camperid, charge, chargetypeid, memo)
                      SELECT
                        bc.year,
                        bc.id,
                        getrate(bc.id, bc.year),
                        1000, -- 1000 in Prod
                        bc.buildingname
                      FROM byyear_campers bc
                      WHERE bc.roomid != 0 AND bc.year = myyear;
                    INSERT INTO gencharges (year, camperid, charge, chargetypeid, memo)
                      SELECT
                        ya.year,
                        MAX(c.id),
                        IF(COUNT(c.id) = 1, 200.0, 400.0),
                        1001, -- 1003 in Prod
                        CONCAT(\"Deposit for \", ya.year)
                      FROM families f, campers c, yearsattending ya
                      WHERE f.id=c.familyid AND c.id=ya.camperid AND ya.year=myyear AND ya.roomid IS NULL
                      GROUP BY f.id;
                    INSERT INTO gencharges (year, camperid, charge, chargetypeid, memo)
                      SELECT
                        bsp.year,
                        bsp.camperid,
                        -(LEAST(SUM(bsp.max_compensation), IFNULL(getrate(bsp.camperid, bsp.year), 200.0))) amount,
                        1002, -- 1021 in Prod
                        IF(COUNT(*) = 1, bsp.staffpositionname, 'Staff Position Credits')
                      FROM byyear_staff bsp
                      WHERE bsp.year = myyear
                      GROUP BY bsp.year, bsp.camperid;
                    INSERT INTO gencharges (year, camperid, charge, chargetypeid, memo)
                      SELECT
                        ya.year,
                        ya.camperid,
                        w.fee,
                        1003, -- 1002 in Prod
                        w.name
                      FROM workshops w, yearattending__workshop yw, yearsattending ya
                      WHERE w.fee > 0 AND yw.is_enrolled = 1 AND w.id = yw.workshopid AND yw.yearattendingid = ya.id;
                  END;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS generate_charges;');
        Schema::dropIfExists('gencharges');
    }
}
