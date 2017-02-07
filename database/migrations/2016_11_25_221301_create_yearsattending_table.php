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
            $table->integer('roomid')->unsigned()->nullable()->default(NULL);
            $table->foreign('roomid')->references('id')->on('rooms');
            $table->integer('days')->default('6');
            $table->tinyInteger('is_private')->default('0');
            $table->timestamp('paydate')->nullable();
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
        Schema::dropIfExists('yearsattending');
    }
}
