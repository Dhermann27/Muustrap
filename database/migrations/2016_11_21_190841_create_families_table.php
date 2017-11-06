<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFamiliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('families', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('address1')->default('Unknown');
            $table->string('address2')->nullable();
            $table->string('city')->default('Unknown');
            $table->string('statecd')->default('ZZ');
            $table->foreign('statecd')->references('id')->on('statecodes');
            $table->string('zipcd')->default('99999');
            $table->string('country')->default('USA');
            $table->tinyInteger('is_address_current')->default('1');
            $table->tinyInteger('is_ecomm')->default('1');
            $table->tinyInteger('is_scholar')->default('0');
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
        Schema::dropIfExists('families');
    }
}
