INSERT INTO muusa.accounts (email, password, is_active, created_at) SELECT
                                                                      email,
                                                                      password,
                                                                      1,
                                                                      registerdate
                                                                    FROM muusa_system.jml_users
                                                                    WHERE block = 0 AND
                                                                          CAST(lastVisitDate AS CHAR(20)) !=
                                                                          '0000-00-00 00:00:00';

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
                                                                              email,
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
                                                                              gradeoffset,
                                                                              sponsor,
                                                                              is_handicap,
                                                                              foodoptionid,
                                                                              churchid,
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
                                                                   id,
                                                                   buildingid,
                                                                   programid,
                                                                   IF(occupancy_adult = '1', 1,
                                                                      IF(occupancy_adult = '2', 2, 3)),
                                                                   IF(occupancy_adult = '1', 1,
                                                                      IF(occupancy_adult = '2', 2, 999)),
                                                                   IF(
                                                                       occupancy_children
                                                                       =
                                                                       '999',
                                                                       1,
                                                                       0),
                                                                   amount,
                                                                   start_year,
                                                                   end_year,
                                                                   created_at
                                                                 FROM
                                                                   muusa_system.muusa_housingrate;

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

INSERT INTO muusa.yearsattending (id, camperid, year, roomid,
                                  days, is_private, created_at) SELECT
                                                                  id,
                                                                  camperid,
                                                                  year,
                                                                  roomid,
                                                                  days,
                                                                  is_private,
                                                                  created_at
                                                                FROM
                                                                  muusa_system.muusa_yearattending;

INSERT INTO muusa.yearattending__staff (yearattendingid, staffpositionid,
                                        is_eaf_paid, created_at) SELECT
                                                                   yearattendingid,
                                                                   staffpositionid,
                                                                   is_eaf_paid,
                                                                   created_at
                                                                 FROM
                                                                   muusa_system.muusa_yearattending__staff;

INSERT INTO muusa.yearattending__volunteer
(yearattendingid, volunteerpositionid, created_at) SELECT
                                                     yearattendingid,
                                                     volunteerpositionid,
                                                     created_at
                                                   FROM
                                                     muusa_system.muusa_yearattending__volunteer;

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

INSERT INTO muusa.camper__staff (camperid, staffpositionid, created_at) SELECT
                                                                          camperid,
                                                                          staffpositionid,
                                                                          created_at
                                                                        FROM muusa_system.muusa_camperid__staff;

