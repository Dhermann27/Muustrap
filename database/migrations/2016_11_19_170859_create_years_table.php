<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateYearsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('years', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('year'); // Testing Only
            $table->date('start_date');
            $table->date('start_open');
            $table->tinyInteger('is_current')->default(0);
            $table->tinyInteger('is_live')->default(0);
            $table->tinyInteger('is_calendar')->default(0);
            $table->tinyInteger('is_crunch')->default(0);
            $table->tinyInteger('is_accept_paypal')->default(0);
            $table->tinyInteger('is_room_select')->default(0);
            $table->tinyInteger('is_workshop_proposal')->default(0);
            $table->tinyInteger('is_artfair')->default(0);
            $table->tinyInteger('is_coffeehouse')->default(0);
        });

        DB::update('ALTER TABLE years AUTO_INCREMENT = 1000');
        DB::unprepared('CREATE FUNCTION getcurrentyear () RETURNS INT DETERMINISTIC BEGIN
 			RETURN(SELECT year FROM years WHERE is_current=1 LIMIT 1);
 		END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP FUNCTION IF EXISTS getcurrentyear');
        Schema::dropIfExists('years');
    }
}
