<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateYearattendingStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yearattending__staff', function (Blueprint $table) {
            $table->integer('yearattendingid')->unsigned();
            $table->foreign('yearattendingid')->references('id')->on('yearsattending');
            $table->integer('staffpositionid')->unsigned();
            $table->foreign('staffpositionid')->references('id')->on('staffpositions');
            $table->tinyInteger('is_eaf_paid');
            $table->timestamps();
            $table->unique(array('yearattendingid', 'staffpositionid'), 'yaid__spid_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('yearattending__staff');
    }
}
