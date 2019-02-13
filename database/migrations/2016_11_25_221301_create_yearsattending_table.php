<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateYearsattendingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yearsattending', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('camperid')->unsigned();
            $table->foreign('camperid')->references('id')->on('campers');
            $table->integer('year');
            $table->integer('programid')->unsigned()->nullable();
            $table->foreign('programid')->references('id')->on('programs');
            $table->integer('roomid')->unsigned()->nullable();
            $table->foreign('roomid')->references('id')->on('rooms');
            $table->integer('days')->default('6');
            $table->tinyInteger('is_setbyadmin')->default('0');
            $table->tinyInteger('is_private')->default('0');
            $table->string('nametag')->default('222215521');
            $table->timestamps();
        });
        DB::update('ALTER TABLE yearsattending AUTO_INCREMENT = 1000');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('yearsattending');
    }
}
