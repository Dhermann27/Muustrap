<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateYearattendingWorkshopTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yearattending__workshop', function (Blueprint $table) {
            $table->integer('yearattendingid')->unsigned();
            $table->foreign('yearattendingid')->references('id')->on('yearsattending');
            $table->integer('workshopid')->unsigned();
            $table->foreign('workshopid')->references('id')->on('workshops');
            $table->tinyInteger('is_leader')->default('0');
            $table->timestamps();
            $table->unique(array('yearattendingid', 'workshopid'), 'yaid__wid_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('yearattending__workshop');
    }
}
