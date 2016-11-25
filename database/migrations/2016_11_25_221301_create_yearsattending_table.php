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
//            $table->foreign('camperid')->references('id')->on('campers');
            $table->integer('year');
            $table->integer('roomid')->nullable()->unsigned();
            $table->foreign('roomid')->references('id')->on('rooms');
            $table->integer('days');
            $table->tinyInteger('is_private');
            $table->timestamp('paydate');
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
