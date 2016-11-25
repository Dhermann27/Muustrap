<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkshopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workshops', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('roomid')->unsigned();
            $table->foreign('roomid')->references('id')->on('rooms');
            $table->integer('timeslotid')->unsigned();
            $table->foreign('timeslotid')->references('id')->on('timeslots');
            $table->integer('order');
            $table->string('name');
            $table->string('led_by');
            $table->text('blurb');
            $table->tinyInteger('m');
            $table->tinyInteger('t');
            $table->tinyInteger('w');
            $table->tinyInteger('th');
            $table->tinyInteger('f');
            $table->integer('enrolled');
            $table->integer('capacity');
            $table->integer('fee');
            $table->timestamps();
        });
        DB::update('ALTER TABLE workshops AUTO_INCREMENT = 1000');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('workshops');
    }
}
