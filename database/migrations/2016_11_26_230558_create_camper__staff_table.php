<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCamperStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('camper__staff', function (Blueprint $table) {
            $table->integer('camperid')->unsigned();
            $table->foreign('camperid')->references('id')->on('campers');
            $table->integer('staffpositionid')->unsigned();
            $table->foreign('staffpositionid')->references('id')->on('staffpositions');
            $table->timestamps();
            $table->unique(array('camperid', 'staffpositionid'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('camper__staff');
    }
}
