<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrackingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracking', function (Blueprint $table) {
            $table->increments('id');
            $table->string('action');
            $table->timestamps();
        });

        DB::unprepared("CREATE VIEW byyear_families AS
                      SELECT
                        ya.year,
                        f.id,
                        f.name,
                        f.address1,
                        f.address2,
                        f.city,
                        f.statecd,
                        f.zipcd,
                        f.country,
                        f.is_address_current,
                        f.is_ecomm,
                        f.is_scholar,
                        COUNT(ya.id)                                     count,
                        SUM(IF(ya.roomid != 0, 1, 0))                    assigned,
                        (SELECT SUM(bh.amount)
                         FROM byyear_charges bh
                         WHERE ya.year = bh.year AND f.id = bh.familyid) balance,
                        MIN(ya.created_at)                               created_at
                      FROM families f, campers c, yearsattending ya
                      WHERE f.id = c.familyid AND c.id = ya.camperid
                      GROUP BY f.id, ya.year;
                    
                    CREATE VIEW byyear_campers AS
                      SELECT
                        ya.year,
                        f.id                                 familyid,
                        f.name                               familyname,
                        f.address1,
                        f.address2,
                        f.city,
                        f.statecd,
                        f.zipcd,
                        f.country,
                        f.is_ecomm,
                        f.is_address_current,
                        c.id,
                        c.pronounid,
                        o.name                               pronounname,
                        c.firstname,
                        c.lastname,
                        c.email,
                        c.phonenbr,
                        c.birthdate,
                        DATE_FORMAT(c.birthdate, '%m/%d/%Y') birthday,
                        getage(c.birthdate, ya.year)         age,
                        p.id                                 programid,
                        p.name                               programname,
                        p.is_program_housing                 is_program_housing,
                        c.roommate,
                        c.sponsor,
                        c.is_handicap,
                        c.foodoptionid,
                        u.id                                 churchid,
                        u.name                               churchname,
                        u.city                               churchcity,
                        u.statecd                            churchstatecd,
                        ya.id                                yearattendingid,
                        ya.days,
                        ya.roomid,
                        r.room_number,
                        b.id                                 buildingid,
                        b.name                               buildingname
                      FROM (families f, campers c, yearsattending ya, programs p, pronouns o)
                        LEFT JOIN (buildings b, rooms r) ON ya.roomid = r.id AND r.buildingid = b.id
                        LEFT JOIN churches u ON c.churchid = u.id
                      WHERE f.id = c.familyid AND c.id = ya.camperid AND p.id = ya.programid
                            AND c.pronounid = o.id;");

        DB::unprepared("CREATE VIEW thisyear_families AS
                      SELECT
                        ya.year,
                        f.id,
                        f.name,
                        f.address1,
                        f.address2,
                        f.city,
                        f.statecd,
                        f.zipcd,
                        f.country,
                        f.is_address_current,
                        f.is_ecomm,
                        f.is_scholar,
                        COUNT(ya.id)                                     count,
                        SUM(IF(ya.roomid != 0, 1, 0))                    assigned,
                        (SELECT SUM(bh.amount)
                         FROM byyear_charges bh
                         WHERE ya.year = bh.year AND f.id = bh.familyid) balance,
                        MIN(ya.created_at)                               created_at
                      FROM families f, campers c, yearsattending ya, years y
                      WHERE f.id = c.familyid AND c.id = ya.camperid AND ya.year=y.year AND y.is_current=1
                      GROUP BY f.id;
                      
                    CREATE VIEW thisyear_campers AS
                      SELECT
                        familyid,
                        familyname,
                        address1,
                        address2,
                        city,
                        statecd,
                        zipcd,
                        country,
                        bc.id,
                        pronounid,
                        pronounname,
                        firstname,
                        lastname,
                        email,
                        phonenbr,
                        birthdate,
                        birthday,
                        age,
                        programid,
                        programname,
                        is_program_housing,
                        roommate,
                        sponsor,
                        is_handicap,
                        foodoptionid,
                        churchid,
                        churchname,
                        churchcity,
                        churchstatecd,
                        yearattendingid,
                        days,
                        roomid,
                        room_number,
                        buildingid,
                        buildingname
                      FROM byyear_campers bc, years y
                      WHERE bc.year = y.year AND y.is_current = 1;");

        DB::unprepared("CREATE VIEW byyear_staff AS
                          SELECT
                            ya.year,
                            c.familyid,
                            c.id         camperid,
                            ya.id        yearattendingid,
                            c.firstname,
                            c.lastname,
                            c.email,
                            sp.name      staffpositionname,
                            sp.id        staffpositionid,
                            cl.max_compensation +
                            IF(ysp.is_eaf_paid = 1, (SELECT IFNULL(SUM(h.amount), 0)
                                                     FROM charges h
                                                     WHERE h.camperid IN (SELECT cp.id
                                                                          FROM campers cp
                                                                          WHERE cp.familyid = c.familyid) AND h.year = ya.year AND
                                                           h.chargetypeid = getchargetypeid('Early Arrival')), 0)
                                         max_compensation,
                            sp.programid programid,
                            sp.pctype    pctype,
                            ysp.created_at
                          FROM campers c, yearsattending ya, yearattending__staff ysp, staffpositions sp, compensationlevels cl
                          WHERE c.id = ya.camperid AND ya.id = ysp.yearattendingid AND ysp.staffpositionid = sp.id
                                AND sp.compensationlevelid = cl.id AND ya.year >= sp.start_year AND ya.year <= sp.end_year
                          UNION ALL
                          SELECT
                            y.year,
                            c.familyid,
                            c.id camperid,
                            0,
                            c.firstname,
                            c.lastname,
                            c.email,
                            sp.name,
                            sp.id,
                            cl.max_compensation,
                            sp.programid,
                            sp.pctype,
                            cs.created_at
                          FROM camper__staff cs, campers c, staffpositions sp, compensationlevels cl, years y
                          WHERE cs.camperid = c.id AND cs.staffpositionid = sp.id AND y.is_current = 1 AND
                                sp.compensationlevelid = cl.id AND y.year >= sp.start_year AND y.year <= sp.end_year;
                        -- Now computing max_comp for each position, group in byyear_charges
                        
                        CREATE VIEW thisyear_staff AS
                          SELECT
                            familyid,
                            camperid,
                            yearattendingid,
                            firstname,
                            lastname,
                            email,
                            staffpositionname,
                            staffpositionid,
                            programid,
                            max_compensation,
                            pctype
                          FROM byyear_staff bsp, years y
                          WHERE bsp.year = y.year AND y.is_current = 1;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP VIEW IF EXISTS thisyear_staff;
                DROP VIEW IF EXISTS byyear_staff;
                DROP VIEW IF EXISTS thisyear_campers;
                DROP VIEW IF EXISTS thisyear_families;
                DROP VIEW IF EXISTS byyear_campers;
                DROP VIEW IF EXISTS byyear_families;');
        Schema::dropIfExists('tracking');
    }
}
