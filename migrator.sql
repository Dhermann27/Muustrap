INSERT INTO muusa.buildings (id, name) SELECT
                                         id,
                                         name
                                       FROM muusa_system.muusa_building
                                       ORDER BY display_order;

INSERT INTO muusa.years (year, start_date, end_prereg, start_open, is_current) SELECT
                                                                                 year,
                                                                                 date,
                                                                                 prereg,
                                                                                 open,
                                                                                 is_current
                                                                               FROM muusa_system.muusa_year;

INSERT INTO muusa.churches (id, name, city, statecd, created_at) SELECT
                                                                   id,
                                                                   name,
                                                                   city,
                                                                   statecd,
                                                                   created_at
                                                                 FROM muusa_system.muusa_church;

INSERT INTO muusa.foodoptions (id, name) SELECT
                                           id,
                                           name
                                         FROM muusa_system.muusa_foodoption;

UPDATE muusa_system.muusa_family
SET statecd = 'IA'
WHERE statecd = 'IO';
UPDATE muusa_system.muusa_family
SET statecd = '__'
WHERE statecd = 'HO';
INSERT INTO muusa.families (id, name, address1, address2, city,
                            statecd, zipcd, country, is_scholar, created_at) SELECT
                                                                               id,
                                                                               name,
                                                                               address1,
                                                                               address2,
                                                                               city,
                                                                               statecd,
                                                                               zipcd,
                                                                               country,
                                                                               is_scholar,
                                                                               created_at
                                                                             FROM
                                                                               muusa_system.muusa_family;

INSERT INTO muusa.chargetypes (id, name, is_shown) SELECT
                                                     id,
                                                     name,
                                                     is_shown
                                                   FROM muusa_system.muusa_chargetype;

DELETE r FROM muusa_system.muusa_camper r LEFT JOIN muusa_system.muusa_family b ON r.familyid = b.id
WHERE b.id IS NULL;
UPDATE muusa_system.muusa_camper
SET email = NULL
WHERE email = "";
-- SELECT id, firstname, lastname, email FROM muusa_system.muusa_camper GROUP BY email HAVING COUNT(*)>1;
INSERT INTO muusa.campers (id, familyid, firstname, lastname,
                           email, birthdate, gradeoffset, sponsor,
                           is_handicap, foodoptionid, churchid, created_at) SELECT
                                                                              c.id,
                                                                              c.familyid,
                                                                              c.firstname,
                                                                              c.lastname,
                                                                              IF(c.email = '', NULL, c.email),
                                                                              c.birthdate,
                                                                              IFNULL(c.gradeoffset, '-5'),
                                                                              c.sponsor,
                                                                              c.is_handicap,
                                                                              IF(c.foodoptionid = '0', 1000,
                                                                                 c.foodoptionid),
                                                                              IF(c.churchid = '0', 2084, c.churchid),
                                                                              c.created_at
                                                                            FROM
                                                                              muusa_system.muusa_camper c;
UPDATE muusa.campers c
SET c.pronounid = (SELECT n.id
                   FROM
                     muusa.pronouns n, muusa_system.muusa_camper cp
                   WHERE
                     n.code
                     =
                     cp.sexcd
  AND c.id=cp.id
                   LIMIT 1);
UPDATE muusa.campers c
SET c.phonenbr = (SELECT n.phonenbr
                  FROM
                    muusa_system.muusa_phonenumber n
                  WHERE
                    n.camperid
                    =
                    c.id
                  ORDER BY
                    n.phonetypeid
                  LIMIT 1);

INSERT INTO muusa.programs (id, name, age_max, age_min, grade_max, grade_min,
                            start_year, end_year, fee, is_program_housing, created_at) SELECT
                                                                                         id,
                                                                                         name,
                                                                                         agemax,
                                                                                         agemin,
                                                                                         grademax,
                                                                                         grademin,
                                                                                         start_year,
                                                                                         end_year,
                                                                                         registration_fee,
                                                                                         is_assign,
                                                                                         created_at
                                                                                       FROM muusa_system.muusa_program;

UPDATE muusa_system.muusa_room r LEFT JOIN muusa_system.muusa_building b ON r.buildingid = b.id
SET r.buildingid = 1017
WHERE b.id IS NULL;
INSERT INTO muusa.rooms (id, buildingid, room_number, capacity, is_workshop, is_handicap,
                         xcoord, ycoord, pixelsize, connected_with, created_at) SELECT
                                                                                  id,
                                                                                  buildingid,
                                                                                  roomnbr,
                                                                                  capacity,
                                                                                  is_workshop,
                                                                                  is_handicap,
                                                                                  xcoord,
                                                                                  ycoord,
                                                                                  pixelsize,
                                                                                  connected_with,
                                                                                  created_at
                                                                                FROM muusa_system.muusa_room;

INSERT INTO muusa.staffpositions (id, name, compensationlevelid,
                                  programid, start_year, end_year, created_at) SELECT
                                                                                 id,
                                                                                 name,
                                                                                 IFNULL((SELECT cl.id
                                                                                         FROM
                                                                                           muusa.compensationlevels cl
                                                                                         WHERE
                                                                                           registration_amount
                                                                                           +
                                                                                           housing_amount
                                                                                           <=
                                                                                           cl.max_compensation
                                                                                         ORDER BY
                                                                                           cl.max_compensation
                                                                                         LIMIT 1), 1004),
                                                                                 programid,
                                                                                 start_year,
                                                                                 end_year,
                                                                                 created_at
                                                                               FROM
                                                                                 muusa_system.muusa_staffposition;

INSERT INTO muusa.volunteerpositions (id, name) SELECT
                                                  id,
                                                  name
                                                FROM muusa_system.muusa_volunteerposition;

INSERT INTO muusa.rates (id, buildingid, programid, occ_min_adult, occ_max_adult, is_children,
                         rate, start_year, end_year, created_at) SELECT
                                                                   r.id,
                                                                   r.buildingid,
                                                                   r.programid,
                                                                   IF(r.occupancy_adult = '1', 1,
                                                                      IF(r.occupancy_adult = '2', 2, 3)),
                                                                   IF(r.occupancy_adult = '1', 1,
                                                                      IF(r.occupancy_adult = '2', 2, 999)),
                                                                   IF(
                                                                       r.occupancy_children
                                                                       =
                                                                       '999',
                                                                       1,
                                                                       0),
                                                                   r.amount,
                                                                   r.start_year,
                                                                   r.end_year,
                                                                   r.created_at
                                                                 FROM
                                                                   muusa_system.muusa_housingrate r
                                                                   LEFT JOIN muusa_system.muusa_building b
                                                                     ON r.buildingid = b.id
                                                                 WHERE b.id IS NOT NULL;

DELETE r FROM muusa_system.muusa_chargegen r LEFT JOIN muusa_system.muusa_camper b ON r.camperid = b.id
WHERE b.id IS NULL;
INSERT INTO muusa.oldgencharges (id, camperid, charge, memo,
                                 chargetypeid, year, created_at) SELECT
                                                                   id,
                                                                   camperid,
                                                                   amount,
                                                                   memo,
                                                                   chargetypeid,
                                                                   year,
                                                                   created_at
                                                                 FROM
                                                                   muusa_system.muusa_chargegen
                                                                 WHERE year != '2017';

DELETE r FROM muusa_system.muusa_yearattending r LEFT JOIN muusa_system.muusa_camper b ON r.camperid = b.id
WHERE b.id IS NULL;
INSERT INTO muusa.yearsattending (id, camperid, year, roomid,
                                  days, is_private, created_at) SELECT
                                                                  id,
                                                                  camperid,
                                                                  year,
                                                                  IF(roomid = '0', NULL, roomid),
                                                                  days,
                                                                  is_private,
                                                                  created_at
                                                                FROM
                                                                  muusa_system.muusa_yearattending;

DELETE r FROM
  muusa_system.muusa_yearattending__staff r LEFT JOIN muusa_system.muusa_staffposition b ON r.staffpositionid = b.id
WHERE b.id IS NULL;
DELETE r FROM
  muusa_system.muusa_yearattending__staff r LEFT JOIN muusa_system.muusa_yearattending b ON r.yearattendingid = b.id
WHERE b.id IS NULL;
INSERT INTO muusa.yearattending__staff (yearattendingid, staffpositionid,
                                        is_eaf_paid, created_at) SELECT
                                                                   yearattendingid,
                                                                   staffpositionid,
                                                                   is_eaf_paid,
                                                                   created_at
                                                                 FROM
                                                                   muusa_system.muusa_yearattending__staff;

DELETE r FROM
  muusa_system.muusa_yearattending__volunteer r LEFT JOIN muusa_system.muusa_yearattending b ON r.yearattendingid = b.id
WHERE b.id IS NULL;
DELETE r FROM muusa_system.muusa_yearattending__volunteer r LEFT JOIN muusa_system.muusa_volunteerposition b
    ON r.volunteerpositionid = b.id
WHERE b.id IS NULL;
INSERT INTO muusa.yearattending__volunteer
(yearattendingid, volunteerpositionid, created_at) SELECT
                                                     yearattendingid,
                                                     volunteerpositionid,
                                                     created_at
                                                   FROM
                                                     muusa_system.muusa_yearattending__volunteer;

# UPDATE muusa_system.muusa_charge
# SET is_deposited = NULL
# WHERE is_deposited = '0000-00-00';
# UPDATE muusa_system.muusa_charge
# SET timestamp = created_at
# WHERE timestamp = '0000-00-00';
DELETE r FROM muusa_system.muusa_charge r LEFT JOIN muusa_system.muusa_camper b ON r.camperid = b.id
WHERE b.id IS NULL;
DELETE r FROM muusa_system.muusa_charge r LEFT JOIN muusa_system.muusa_chargetype b ON r.chargetypeid = b.id
WHERE b.id IS NULL;
INSERT INTO muusa.charges (id, camperid, amount, memo, chargetypeid,
                           deposited_date, timestamp, year, created_at) SELECT
                                                                          id,
                                                                          camperid,
                                                                          amount,
                                                                          memo,
                                                                          chargetypeid,
                                                                          is_deposited,
                                                                          timestamp,
                                                                          year,
                                                                          created_at

                                                                        FROM
                                                                          muusa_system.muusa_charge;

INSERT INTO muusa.scholarships (id, yearattendingid, program_pct,
                                housing_pct, is_muusa, created_at) SELECT
                                                                     id,
                                                                     yearattendingid,
                                                                     registration_pct,
                                                                     housing_pct,
                                                                     is_muusa,
                                                                     created_at
                                                                   FROM
                                                                     muusa_system.muusa_scholarship;

DELETE r FROM muusa_system.muusa_camperid__staff r LEFT JOIN muusa_system.muusa_camper b ON r.camperid = b.id
WHERE b.id IS NULL;
INSERT INTO muusa.camper__staff (camperid, staffpositionid, created_at) SELECT
                                                                          camperid,
                                                                          staffpositionid,
                                                                          created_at
                                                                        FROM muusa_system.muusa_camperid__staff;

INSERT INTO muusa.contactboxes (name, emails, created_at) SELECT
                                                            name,
                                                            email,
                                                            NOW()
                                                          FROM muusa_system.jml_alfcontact;

/* Don't forget to alter the auto_increments
ALTER TABLE contactus AUTO_INCREMENT = 1000*/

DROP FUNCTION IF EXISTS getage;
CREATE FUNCTION getage(birthdate DATE, year YEAR)
  RETURNS INT DETERMINISTIC
  BEGIN
    RETURN DATE_FORMAT(FROM_DAYS(DATEDIFF((SELECT start_date
                                           FROM years y
                                           WHERE year = y.year), birthdate)), '%Y');
  END;

DROP VIEW IF EXISTS byyear_families;
CREATE VIEW byyear_families AS
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
    f.is_ecomm,
    COUNT(ya.id) count,
    SUM(IF(ya.roomid!=0,1,0)) assigned,
    (SELECT SUM(bh.amount) FROM byyear_charges bh WHERE ya.year=bh.year AND f.id=bh.familyid) balance,
    MIN(ya.created_at) created_at
  FROM families f, campers c, yearsattending ya
  WHERE f.id = c.familyid AND c.id = ya.camperid
  GROUP BY f.id, ya.year;


DROP VIEW IF EXISTS byyear_campers;
CREATE VIEW byyear_campers AS
  SELECT
    ya.year,
    f.id                                         familyid,
    f.name                                       familyname,
    f.address1,
    f.address2,
    f.city,
    f.statecd,
    f.zipcd,
    f.country,
    f.is_ecomm,
    c.id,
    c.pronounid,
    o.name                                       pronounname,
    c.firstname,
    c.lastname,
    c.email,
    c.phonenbr,
    c.birthdate,
    DATE_FORMAT(c.birthdate, '%m/%d/%Y')         birthday,
    getage(c.birthdate, ya.year)                 age,
    c.gradeoffset,
    ya.year-c.gradyear+12 grade,
    p.id                                         programid,
    p.name                                       programname,
    p.is_program_housing                         is_program_housing,
    c.roommate,
    c.sponsor,
    c.is_handicap,
    c.foodoptionid,
    u.id                                         churchid,
    u.name                                       churchname,
    u.city                                       churchcity,
    u.statecd                                    churchstatecd,
    ya.id                                        yearattendingid,
    ya.days,
    ya.roomid,
    r.room_number,
    b.id                                         buildingid,
    b.name                                       buildingname
  FROM (families f, campers c, yearsattending ya, programs p, pronouns o)
    LEFT JOIN (buildings b, rooms r) ON ya.roomid = r.id AND r.buildingid = b.id
    LEFT JOIN churches u ON c.churchid = u.id
  WHERE f.id = c.familyid AND c.id = ya.camperid AND p.id = getprogramidbycamperid(c.id, ya.year)
        AND c.pronounid = o.id;

DROP VIEW IF EXISTS byyear_charges;
CREATE VIEW byyear_charges AS
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

DROP VIEW IF EXISTS thisyear_families;
CREATE VIEW thisyear_families AS
  SELECT
    yf.id,
    yf.name,
    yf.address1,
    yf.address2,
    yf.city,
    yf.statecd,
    yf.zipcd,
    yf.country,
    yf.count,
    yf.assigned,
    yf.balance,
    yf.created_at
  FROM byyear_families yf, years y
  WHERE yf.year = y.year AND y.is_current = 1;

DROP VIEW IF EXISTS thisyear_charges;
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
  WHERE c.id = bh.camperid AND bh.chargetypeid = g.id AND bh.year = y.year AND y.is_current = 1;

DROP VIEW IF EXISTS thisyear_campers;
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
    id,
    pronounid,
    pronounname,
    firstname,
    lastname,
    email,
    phonenbr,
    birthdate,
    birthday,
    age,
    grade,
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
  WHERE bc.year = y.year AND y.is_current = 1;

    DROP VIEW IF EXISTS byyear_staff;
    CREATE VIEW byyear_staff AS
      SELECT
        ya.year,
        c.familyid,
        c.id                                                                 camperid,
        MAX(ya.id)                                                           yearattendingid,
        c.firstname,
        c.lastname,
        MAX(sp.name)                                                         staffpositionname,
        MAX(sp.id)                                                           staffpositionid,
        LEAST(IFNULL(getrate(c.id, ya.year), 150), SUM(cl.max_compensation)) +
        IF(MAX(ysp.is_eaf_paid) = 1, (SELECT IFNULL(SUM(h.amount), 0)
                                 FROM charges h
                                 WHERE h.camperid IN (SELECT cp.id
                                                      FROM campers cp
                                                      WHERE cp.familyid = c.familyid) AND h.year = ya.year AND
                                       h.chargetypeid = getchargetypeid('Early Arrival')), 0)
                                                                             compensation,
        MAX(sp.programid)                                                    programid,
        MAX(ysp.created_at)
      FROM campers c, yearsattending ya, yearattending__staff ysp, staffpositions sp, compensationlevels cl
      WHERE c.id = ya.camperid AND ya.id = ysp.yearattendingid AND ysp.staffpositionid = sp.id
            AND sp.compensationlevelid=cl.id AND ya.year >= sp.start_year AND ya.year <= sp.end_year
      GROUP BY ya.year, c.id
    UNION ALL
    SELECT
      MAX(y.year),
      c.familyid,
      c.id camperid,
      0,
      c.firstname,
      c.lastname,
      MAX(sp.name),
      MAX(sp.id),
      LEAST(150, SUM(cl.max_compensation)),
      MAX(sp.programid),
      MAX(cs.created_at)
    FROM camper__staff cs, campers c, staffpositions sp, compensationlevels cl, years y
    WHERE cs.camperid = c.id AND cs.staffpositionid = sp.id AND y.is_current = 1 AND
          sp.compensationlevelid=cl.id AND y.year >= sp.start_year AND y.year <= sp.end_year
    GROUP BY c.id;
  -- No staff position id because of multiple credits line, must be multiple credits due to amount limits

  DROP VIEW IF EXISTS thisyear_staff;
  CREATE VIEW thisyear_staff AS
    SELECT familyid, camperid, yearattendingid, firstname, lastname,
      staffpositionname, staffpositionid, programid, compensation
    FROM byyear_staff bsp, years y
    WHERE bsp.year=y.year AND y.is_current=1;

DROP FUNCTION IF EXISTS getrate;
CREATE FUNCTION getrate (mycamperid INT, myyear YEAR)
  RETURNS FLOAT DETERMINISTIC
  BEGIN
    DECLARE age, occupants, days, staff, programid INT DEFAULT 0;
    SELECT getage(c.birthdate, myyear), COUNT(*), MAX(ya.days), IF(MAX(ysp.staffpositionid)>0,1,0),
      getprogramidbycamperid(mycamperid, myyear)
    INTO age, occupants, days, staff, programid
    FROM (campers c, yearsattending ya, yearsattending yap, campers cp)
      LEFT JOIN yearattending__staff ysp
        ON ysp.yearattendingid=ya.id AND ysp.staffpositionid IN (1023,1025)
    WHERE c.id=mycamperid AND c.id=ya.camperid AND ya.year=myyear AND ya.roomid=yap.roomid
          AND ya.year=yap.year AND yap.camperid=cp.id;
    IF staff=1 THEN
      RETURN days * 58;
    -- DAH Meyer/Burt Staff Housing Rate $58.00/night
    ELSE
      RETURN (SELECT IFNULL(hr.rate*days,0)
              FROM yearsattending ya, rooms r, rates hr
              WHERE ya.camperid=mycamperid AND ya.year=myyear AND r.id=ya.roomid AND
                    r.buildingid=hr.buildingid AND hr.programid=programid AND
                    occupants>=hr.min_occupancy AND occupants<=hr.max_occupancy AND
                    myyear>=hr.start_year AND myyear<=hr.end_year);
    END IF;
  END;

DROP PROCEDURE IF EXISTS generate_charges;
CREATE DEFINER =`root`@`localhost` PROCEDURE generate_charges(myyear YEAR)
  BEGIN
    SET SQL_MODE='';
    DELETE FROM gencharges WHERE year=myyear;
    INSERT INTO gencharges (year, camperid, charge, chargetypeid, memo)
      SELECT
        bc.year,
        bc.id,
        getrate(bc.id, bc.year),
        1000,
        bc.buildingname
      FROM byyear_campers bc
      WHERE bc.roomid!=0 AND bc.year=myyear;
    INSERT INTO gencharges (year, camperid, charge, chargetypeid, memo)
      SELECT
        bf.year,
        (SELECT id
         FROM campers
         WHERE familyid = bf.id
         LIMIT 1),
        IF(bf.count = 1, 150.0, 300),
        1003,
        CONCAT("Deposit for ", bf.year)
      FROM byyear_families bf
      WHERE bf.year=myyear AND bf.assigned=0;
    INSERT INTO gencharges (year, camperid, charge, chargetypeid, memo)
      SELECT bsp.year, bsp.camperid, -(bsp.compensation) amount, 1021, bsp.staffpositionname
      FROM byyear_staff bsp
      WHERE bsp.year=myyear;
    INSERT INTO gencharges (year, camperid, charge, chargetypeid, memo)
      SELECT ya.year, ya.camperid, w.fee, 1002, w.name
      FROM workshops w, yearattending__workshop yw, yearsattending ya
      WHERE w.fee > 0 AND yw.is_enrolled=1 AND w.id=yw.workshopid AND yw.yearattendingid=ya.id;
  END;


DROP PROCEDURE IF EXISTS workshops;
CREATE DEFINER =`root`@`localhost` PROCEDURE workshops()
  BEGIN
    DECLARE done INT DEFAULT FALSE;
    DECLARE myid, mycapacity INT;
    DECLARE cur CURSOR FOR SELECT id, capacity-1 FROM workshops;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done=TRUE;

    UPDATE yearattending__workshop SET is_enrolled=0;

    UPDATE workshops w
    SET w.enrolled = (SELECT COUNT(*)
                      FROM yearattending__workshop yw
                      WHERE w.id = yw.workshopid);
    UPDATE yearattending__workshop yw, thisyear_campers tc, workshops w
      SET yw.is_leader = 1
    WHERE yw.workshopid=w.id AND yw.yearattendingid=tc.yearattendingid
          AND w.led_by LIKE CONCAT('%', tc.firstname, ' ', tc.lastname, '%');

    OPEN cur;

    read_loop: LOOP
      FETCH cur INTO myid, mycapacity;
      IF done THEN
        LEAVE read_loop;
      END IF;
      UPDATE yearattending__workshop yw
      SET yw.is_enrolled=1
      WHERE yw.workshopid=myid AND (yw.is_leader=1 OR
            yw.created_at<=(SELECT MAX(created_at) FROM
              (SELECT ywp.created_at
               FROM yearattending__workshop ywp
               WHERE ywp.workshopid=myid AND ywp.is_leader=0
               ORDER BY created_at
               LIMIT mycapacity)
                AS t1));
      END LOOP;

    CLOSE cur;

END;

DROP PROCEDURE IF EXISTS `duplicate`;
CREATE DEFINER=`root`@`localhost` PROCEDURE `duplicate`(beforeid INT, afterid INT)
  BEGIN
    DECLARE family, count INT DEFAULT 0;
    IF beforeid != 0 AND afterid != 0 THEN
      SELECT familyid INTO family FROM campers WHERE id=beforeid;
      UPDATE yearsattending ya SET ya.camperid=afterid WHERE ya.camperid=beforeid AND (SELECT COUNT(*) FROM yearsattending yap WHERE yap.camperid=afterid AND ya.year=yap.year)=0;
      UPDATE oldgencharges SET camperid=afterid WHERE camperid=beforeid;
      UPDATE gencharges SET camperid=afterid WHERE camperid=beforeid;
      UPDATE charges SET camperid=afterid WHERE camperid=beforeid;
      DELETE FROM campers WHERE id=beforeid;
      SELECT COUNT(*) INTO count FROM campers WHERE familyid=family;
      IF count = 0 THEN
        DELETE FROM families WHERE id=family;
      END IF;
    END IF;
  END;

DROP FUNCTION IF EXISTS getprogramidbycamperid;
CREATE FUNCTION getprogramidbycamperid (id INT, myyear INT) RETURNS INT DETERMINISTIC BEGIN
  DECLARE age, grade INT DEFAULT 0;
  SELECT getage(c.birthdate, myyear) INTO age FROM campers c WHERE c.id=id;
  SELECT myyear-c.gradyear+12 INTO grade FROM campers c WHERE c.id=id;
  RETURN(SELECT p.id FROM programs p WHERE p.age_min<=age AND p.age_max>=age AND p.grade_min<=grade AND p.grade_max>=grade LIMIT 1);
END;

DROP FUNCTION IF EXISTS getprogramidbyname;
CREATE FUNCTION getprogramidbyname (programname VARCHAR(1024)) RETURNS INT DETERMINISTIC BEGIN
    RETURN(SELECT p.id FROM programs p WHERE p.name LIKE CONCAT('%', programname, '%') ORDER BY age_min DESC LIMIT 1);
END;