<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('charges', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('camperid')->unsigned();
            $table->foreign('camperid')->references('id')->on('campers');
            $table->float('amount');
            $table->string('memo')->nullable();
            $table->integer('chargetypeid')->unsigned();
            $table->foreign('chargetypeid')->references('id')->on('chargetypes');
            $table->date('deposited_date')->nullable();
            $table->date('timestamp')->useCurrent();
            $table->integer('year');
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
        Schema::dropIfExists('charges');
    }
}
