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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rates');
    }
}
