<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffpositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staffpositions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('compensationlevelid')->unsigned();
            $table->foreign('compensationlevelid')->references('id')->on('compensationlevels');
            $table->integer('programid')->unsigned();
            $table->foreign('programid')->references('id')->on('programs');
            $table->integer('pctype')->default(0);
            $table->integer('start_year');
            $table->integer('end_year');
            $table->timestamps();
        });
        DB::update('ALTER TABLE staffpositions AUTO_INCREMENT = 1000');

        DB::unprepared('CREATE FUNCTION getstaffpositionid (staffpositionname VARCHAR(1024), year INT) RETURNS INT DETERMINISTIC 	BEGIN
 			RETURN(SELECT sp.id FROM staffpositions sp WHERE sp.name LIKE CONCAT(\'%\', staffpositionname, \'%\') AND year>=sp.start_year AND year<=sp.end_year LIMIT 1);
 		END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP FUNCTION IF EXISTS getstaffpositionid');
        Schema::dropIfExists('staffpositions');
    }
}
