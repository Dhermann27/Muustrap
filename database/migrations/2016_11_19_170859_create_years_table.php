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
            $table->integer('year')->unique();
            $table->date('start_date');
            $table->date('end_prereg');
            $table->date('start_open');
            $table->tinyInteger('is_current');
        });

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
