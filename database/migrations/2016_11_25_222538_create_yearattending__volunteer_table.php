<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateYearattendingVolunteerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yearattending__volunteer', function (Blueprint $table) {
            $table->integer('yearattendingid')->unsigned();
            $table->foreign('yearattendingid')->references('id')->on('yearsattending');
            $table->integer('volunteerpositionid')->unsigned();
            $table->foreign('volunteerpositionid')->references('id')->on('volunteerpositions');
            $table->timestamps();
            $table->unique(array('yearattendingid', 'volunteerpositionid'), 'yaid__vpid_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('yearattending__volunteer');
    }
}
