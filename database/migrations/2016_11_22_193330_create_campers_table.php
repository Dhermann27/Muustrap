<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('familyid')->unsigned();
            $table->foreign('familyid')->references('id')->on('families');
            $table->integer('pronounid')->unsigned()->nullable();
            $table->foreign('pronounid')->references('id')->on('pronouns');
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('email')->nullable()->unique();
            $table->bigInteger('phonenbr')->nullable();
            $table->date('birthdate')->nullable();
            //$table->integer('gradeoffset')->default('-5');
            $table->integer('gradyear')->default('1901');
            $table->string('roommate')->nullable();
            $table->string('sponsor')->nullable();
            $table->tinyInteger('is_handicap')->default('0');
            $table->integer('foodoptionid')->unsigned()->default('1000'); // No Restriction
            $table->foreign('foodoptionid')->references('id')->on('foodoptions');
            $table->integer('churchid')->unsigned()->default('2084'); // Church of the Larger Fellowship
            $table->foreign('churchid')->references('id')->on('churches');
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
        Schema::dropIfExists('campers');
    }
}
