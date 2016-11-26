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
            $table->char('sexcd');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email')->nullable();
            $table->bigInteger('phonenbr');
            $table->date('birthdate');
            $table->integer('gradeoffset');
            $table->string('sponsor')->nullable();
            $table->tinyInteger('is_handicap');
            $table->integer('foodoptionid')->unsigned();
            $table->foreign('foodoptionid')->references('id')->on('foodoptions');
            $table->integer('churchid')->unsigned();
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
