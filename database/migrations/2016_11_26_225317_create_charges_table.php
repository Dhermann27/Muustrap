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
        DB::update('ALTER TABLE charges AUTO_INCREMENT = 1000');

        DB::unprepared("CREATE VIEW byyear_charges AS
                          SELECT
                            h.id,
                            h.year,
                            c.familyid,
                            h.camperid,
                            h.amount,
                            h.deposited_date,
                            h.chargetypeid,
                            g.name chargetypename,
                            h.timestamp,
                            h.memo
                          FROM charges h, chargetypes g, campers c
                          WHERE h.chargetypeid = g.id AND h.camperid = c.id
                          UNION ALL
                          SELECT
                            0,
                            hg.year,
                            c.familyid,
                            hg.camperid,
                            hg.charge,
                            NULL,
                            g.id,
                            g.name,
                            NULL,
                            hg.memo
                          FROM campers c, gencharges hg, chargetypes g
                          WHERE c.id = hg.camperid AND g.id = hg.chargetypeid
                          UNION ALL
                          SELECT
                            0,
                            og.year,
                            c.familyid,
                            og.camperid,
                            og.charge,
                            NULL,
                            g.id,
                            g.name,
                            NULL,
                            og.memo
                          FROM campers c, oldgencharges og, chargetypes g
                          WHERE c.id = og.camperid AND g.id = og.chargetypeid;
                          
                        CREATE VIEW thisyear_charges AS
                          SELECT
                            bh.id,
                            y.year,
                            c.familyid,
                            c.id   camperid,
                            bh.amount,
                            bh.deposited_date,
                            bh.chargetypeid,
                            g.name chargetypename,
                            bh.timestamp,
                            bh.memo
                          FROM campers c, byyear_charges bh, chargetypes g, years y
                          WHERE c.id = bh.camperid AND bh.chargetypeid = g.id AND bh.year = y.year AND y.is_current = 1;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP VIEW IF EXISTS thisyear_charges;
                    DROP VIEW IF EXISTS byyear_charges;');
        Schema::dropIfExists('charges');
    }
}
