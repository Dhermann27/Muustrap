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
            $table->string('roommate')->nullable();
            $table->string('sponsor')->nullable();
            $table->tinyInteger('is_handicap')->nullable();
            $table->integer('foodoptionid')->unsigned()->nullable();
            $table->foreign('foodoptionid')->references('id')->on('foodoptions');
            $table->integer('churchid')->unsigned()->nullable();
            $table->foreign('churchid')->references('id')->on('churches');
            $table->timestamps();
        });
        DB::update('ALTER TABLE campers AUTO_INCREMENT = 1000');
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
