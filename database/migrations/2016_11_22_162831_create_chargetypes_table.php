<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChargetypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chargetypes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->tinyInteger('is_shown');
        });
        DB::update('ALTER TABLE chargetypes AUTO_INCREMENT = 1000');

        DB::unprepared('CREATE FUNCTION getchargetypeid (chargetypename VARCHAR(1024)) RETURNS INT DETERMINISTIC BEGIN
 			RETURN(SELECT t.id FROM chargetypes t WHERE t.name LIKE CONCAT(\'%\', chargetypename, \'%\') LIMIT 1);
 		END');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP FUNCTION IF EXISTS getchargetypeid');
        Schema::dropIfExists('chargetypes');
    }
}
