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
        DB::unprepared('CREATE FUNCTION getprogramidbycamperid (id INT, year INT) RETURNS INT DETERMINISTIC BEGIN
            DECLARE age, grade INT DEFAULT 0;
            SELECT getage(c.birthdate, year) INTO age FROM campers c WHERE c.id=id;
            SELECT age+c.gradeoffset INTO grade FROM campers c WHERE c.id=id;
            RETURN(SELECT p.id FROM programs p WHERE p.age_min<=age AND p.age_max>=age AND p.grade_min<=grade AND p.grade_max>=grade LIMIT 1);
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
        DB::unprepared('DROP FUNCTION IF EXISTS getprogramidbycamperid');
        Schema::dropIfExists('programs');
    }
}
