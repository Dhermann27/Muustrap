<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('age_max');
            $table->integer('age_min');
            $table->integer('grade_max');
            $table->integer('grade_min');
            $table->text('blurb')->nullable();
            $table->string('link')->nullable();
            $table->text('letter')->nullable();
            $table->text('form')->nullable();
            $table->text('calendar')->nullable();
            $table->tinyInteger('is_program_housing');
            $table->timestamps();
        });

        DB::unprepared('CREATE FUNCTION getprogramidbyname (programname VARCHAR(1024), year INT) RETURNS INT DETERMINISTIC 	BEGIN
 			RETURN(SELECT p.id FROM programs p WHERE p.name LIKE CONCAT(\'%\', programname, \'%\') ORDER BY age_min DESC LIMIT 1);
 		END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP FUNCTION IF EXISTS getprogramidbyname');
        Schema::dropIfExists('programs');
    }
}
