<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGenchargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gencharges', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('camperid')->unsigned();
            $table->foreign('camperid')->references('id')->on('campers');
            $table->float('charge');
            $table->string('memo')->nullable();
            $table->integer('chargetypeid')->unsigned();
            $table->foreign('chargetypeid')->references('id')->on('chargetypes');
            $table->integer('year');
        });
        DB::update('ALTER TABLE gencharges AUTO_INCREMENT = 1000');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gencharges');
    }
}
