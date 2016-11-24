<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->integer('start_year');
            $table->integer('end_year');
            $table->timestamps();
        });
        DB::update('ALTER TABLE staffpositions AUTO_INCREMENT = 1000');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('staffpositions');
    }
}
