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
//            $table->foreign('camperid')->references('id')->on('campers');
            $table->float('charge');
            $table->string('memo')->nullable();
            $table->integer('chargetypeid')->unsigned();
            $table->foreign('chargetypeid')->references('id')->on('chargetypes');
            $table->integer('year');
        });

        DB::unprepared('CREATE PROCEDURE generate_charges() BEGIN
            TRUNCATE gencharges;
	        INSERT INTO gencharges (year, camperid, amount, chargetypeid, memo)
        		SELECT y.year, ya.camperid, getrate(ya.camperid, y.year) amount, 1000, d.name
			        FROM years y, yearsattending ya, campers c, rooms r, buildings d
			        WHERE y.is_current=1 AND y.year=ya.year AND ya.roomid!=0 AND ya.camperid=c.id AND ya.roomid=r.id AND r.buildingid=d.id;
	        INSERT INTO gencharges (year, camperid, amount, chargetypeid, memo)
		        SELECT y.year, ya.camperid, IFNULL(LEAST(getprogramfee(ya.camperid, y.year), 30*ya.days),0) amount, 1003, CONCAT(c.firstname, " ", c.lastname) 
			    FROM years y, yearsattending ya, campers c
			    WHERE y.is_current=1 AND y.year=ya.year AND ya.camperid=c.id;
	        INSERT INTO gencharges (year, camperid, amount, chargetypeid, memo)
	        	SELECT tsp.year, tsp.camperid, -(tsp.housing_amount) amount, 1021, tsp.staffpositionname
		        FROM muusa_thisyear_staff tsp;
        END');// AND getrate(ya.camperid, y.year)>0; TODO: Still needed?
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS generate_charges');
        Schema::dropIfExists('gencharges');
    }
}
