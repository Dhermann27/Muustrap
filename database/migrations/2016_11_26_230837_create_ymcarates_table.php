<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateYmcaratesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::create('ymcarates', function (Blueprint $table) {
//            $table->increments('id');
//            $table->integer('buildingid')->unsigned();
//            $table->foreign('buildingid')->references('id')->on('buildings');
//            $table->integer('age_min');
//            $table->integer('age_max');
//            $table->float('amount');
//            $table->timestamps();
//        }); TODO: Still needed?
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        Schema::dropIfExists('ymcarates');
    }
}
