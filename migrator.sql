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

INSERT INTO muusa.campers (id, familyid, sexcd, firstname, lastname,
                           email, phonenbr, birthdate, gradeoffset, sponsor,
                           is_handicap, foodoptionid, churchid, created_at) SELECT
                                                                              id,
                                                                              familyid,
                                                                              sexcd,
                                                                              firstname,
                                                                              lastname,
                                                                              IF(email = '', NULL, email),
                                                                              (SELECT n.phonenbr
                                                                               FROM
                                                                                 muusa_system.muusa_phonenumber n
                                                                               WHERE
                                                                                 n.camperid
                                                                                 =
                                                                                 id
                                                                               ORDER BY
                                                                                 phonetypeid
                                                                               LIMIT 1),
                                                                              birthdate,
                                                                              IFNULL(gradeoffset, '-5'),
                                                                              sponsor,
                                                                              is_handicap,
                                                                              IF(foodoptionid = '0', 1000,
                                                                                 foodoptionid),
                                                                              IF(churchid = '0', 2084, churchid),
                                                                              created_at
                                                                            FROM
                                                                              muusa_system.muusa_camper;

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

UPDATE muusa_system.muusa_charge
SET is_deposited = NULL
WHERE is_deposited = '0000-00-00';
UPDATE muusa_system.muusa_charge
SET timestamp = created_at
WHERE timestamp = '0000-00-00';
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
ALTER TABLE muusa.charges AUTO_INCREMENT = ( SELECT MAX(id) FROM charges) + 1;

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
    COUNT(ya.id) count,
    MAX(paydate) paydate
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
    c.id,
    c.sexcd,
    c.firstname,
    c.lastname,
    c.email,
    c.birthdate,
    DATE_FORMAT(c.birthdate, '%m/%d/%Y')         birthday,
    getage(c.birthdate, ya.year)                 age,
    c.gradeoffset,
    getage(c.birthdate, ya.year) + c.gradeoffset grade,
    p.id                                         programid,
    p.name                                       programname,
    c.sponsor,
    c.is_handicap,
    c.foodoptionid,
    u.id                                         churchid,
    u.name                                       churchname,
    u.city                                       churchcity,
    u.statecd                                    churchstatecd,
    ya.id                                        yearattendingid,
    ya.paydate,
    ya.days,
    ya.roomid,
    r.room_number,
    b.id                                         buildingid,
    b.name                                       buildingname
  FROM (families f, campers c, yearsattending ya, programs p)
    LEFT JOIN (buildings b, rooms r) ON ya.roomid = r.id AND r.buildingid = b.id
    LEFT JOIN churches u ON c.churchid = u.id
  WHERE f.id = c.familyid AND c.id = ya.camperid AND p.id = getprogramidbycamperid(c.id, ya.year);

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
  WHERE c.id = hg.camperid AND g.id = hg.chargetypeid;

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