<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('buildingid')->unsigned()->nullable();
            $table->foreign('buildingid')->references('id')->on('buildings');
            $table->string('room_number');
            $table->integer('capacity');
            $table->tinyInteger('is_workshop');
            $table->tinyInteger('is_handicap');
            $table->integer('xcoord');
            $table->integer('ycoord');
            $table->integer('pixelsize');
            $table->integer('connected_with');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rooms');
    }
}
