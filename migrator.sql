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
    SUM(IF(ya.roomid!=0,1,0)) assigned
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
    getage(c.birthdate, ya.year) + c.gradeoffset grade,
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
    yf.assigned
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
    gradeoffset,
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

INSERT INTO `workshops` (`id`, `roomid`, `timeslotid`, `order`, `name`, `led_by`, `blurb`, `m`, `t`, `w`, `th`, `f`, `enrolled`, `capacity`, `fee`, `created_at`, `updated_at`)
VALUES
  (1128, 1123, 1000, 1, 'Gentle Flow Yoga', 'Pam Dempsey',
         'This slow-moving yoga sequence is designed to be relaxing and rejuvenating (Not a cardio class or "workout"). Participants should bring a towel and a mat. All skill levels welcome, and beginners are especially encouraged to join.',
         1, 1, 1, 1, 1, 0, 15, 0, NOW(), NULL),
  (1129, 1123, 1000, 2, 'Dawn Photo Walk', 'Roger Easley', 'Sunrise is a magical time to be outside at camp, especially with your camera. Will there be golden reflections on the lake, or cool mist? Perhaps some geese? We will walk along the waterfront up to the dam. No lecture, but leader can answer photo related questions. This workshop will be offered from 6:00-7:00am.', 0, 0, 1, 0, 0, 0, 999, 0, NOW(), NULL),
  (1130, 1123, 1000, 3, 'Open Water Swimming', 'Kate Kistler Patterson', 'Join experienced, long-distance swimmers for an early morning, open water swim in Sunnen Lake. The course will be set by the workshop leader. Although swimmers will be accompanied by Trout Lodge waterfront staff, registrants should be comfortable swimming for 45-60 minutes without a break.', 1, 1, 1, 0, 0, 0, 10, 0, NOW(), NULL),
  (1131, 1123, 1001, 1, 'Awesome Choir', 'Pam Blevins Hinkle', 'Learn vocal and choral technique, sing a variety of quality music, support the Tuesday-Friday Morning Celebration, and have fun! Choir also rehearses from 8:00-8:30am, Tuesday through Friday.', 1, 1, 1, 1, 1, 0, 50, 0, NOW(), NULL),
  (1132, 1123, 1001, 2, 'Photography for Everyone', 'Roger Easley', 'Today\'s cameras and smart phones allow us to take lots of photos and see the results immediately. Confused by your camera? Wish your photos were more shareable? No matter how you take pictures, you can learn how to get better results. We will practice changing camera settings and posing people.', 1, 1, 1, 1, 1, 0, 20, 0, NOW(), NULL),
  (1133, 1123, 1001, 3, 'Yoga Flow', 'Ruth Elliott', 'Ruth will lead a yoga class begining with yin yoga poses,flowing through vinyasa poses, and finishing with stretching and seated or guided meditation. There will be music during class and a live crystal singing bowl to open and close the practice. Some yoga experience is suggested, but all are welcome to come and practice. Modifications and variations will be offered to make the class more accessible or more challenging depending on each student\'s needs and experience.', 1, 1, 1, 1, 1, 0, 40, 0, NOW(), NULL),
  (1134, 1123, 1001, 4, 'Tai Chi', 'Nan Fox', 'Come join us for this beautiful and relaxing form of moving meditation. We will incorporate Chi Gong warm-up exercises, music, and poetry. Experience is helpful, but beginners can be accomodated as well. Transportation will be available to and from the workshop.', 1, 1, 1, 1, 1, 0, 20, 0, NOW(), NULL),
  (1135, 1123, 1001, 5, 'A Prayer for You and the Universe', 'Eric Hinkle', 'We will explore various prayer traditions. Exploration will become action by creating prayers for ourselves and the universe. A portion of each session will be set aside for silent prayer to our individual concept of the great mystery.', 1, 1, 1, 1, 1, 0, 20, 0, NOW(), NULL),
  (1136, 1123, 1001, 6, 'Chaplain Training for Youth and Young Adults', 'Ruth and Aletha Hinkle', 'Get the skills you need to support your peers during this intimate week of camp. Participants will learn how to offer spiritual and emotional resources to suffering individuals and communities. This training qualifies participants to serve as a youth or young adult chaplain at UU youth conferences.', 1, 1, 1, 1, 1, 0, 20, 0, NOW(), NULL),
  (1137, 1123, 1001, 7, 'Fabric Workshop for Beginners', 'Diane Loupe', 'Learn various techniques for tie-dying, including traditional and ice-dying, explore silk painting, and let your spirit create. This will be a basic class for those who want to explore creating with fabric.', 1, 1, 1, 1, 1, 0, 20, 0, NOW(), NULL),
  (1138, 1123, 1001, 8, 'Making a Packing Tape Drum', 'Nicole Nichols', 'Ever wanted to make your own drum? Join us as we make drums out of some simple materials - wood and packing tape. We will make and decorate our drum in one session. Please bring your own hammer - other supplies provided.', 1, 0, 0, 0, 0, 0, 20, 0, NOW(), NULL),
  (1139, 1123, 1001, 9, 'Coloring for Active Meditation', 'Nicole Nichols', 'Back by popular demand! Come spend some time coloring with friends. Repetitive motions such as coloring can help reinforce your focus and shift your attention to a relaxed state. No artistic skills needed to relieve stress! Materials will be provided - just bring your own sense of fun!', 0, 0, 1, 0, 1, 0, 25, 0, NOW(), NULL),
  (1140, 1123, 1001, 10, 'Essential Oil Make and Take', 'Nicole Nichols', 'Ever wanted to learn about essential oil? Essential oils can be a safe, natural option to protect and maintain your family\'s health. Come make and take some everyday use products using essential oils. DAY 1: Make essential oil bath salts or sugar scrubs. DAY 2: Make essential oil roller ball remedies or sprays.', 0, 1, 0, 1, 0, 0, 12, 0, NOW(), NULL),
  (1141, 1123, 1001, 11, 'Contra Dancing ', 'Ken Sharp and Laurel Spahn', 'Contra dancing is social interaction, meeting old friends and making new ones, set to music that can be lively or gentle. A caller provides a "walk through" practice before the dance and gives instructions during the dance. Dancers of all levels of experience and ability are welcome; they generally wear large smiles during the dances.', 1, 1, 1, 1, 1, 0, 40, 0, NOW(), NULL),
  (1142, 1123, 1002, 1, 'Beginning Drawing with Mixed Media', 'Becky Bartow', 'In this workshop, we will work on a variety of drawing techniques and visual awareness. We will use mixed medias including pastels, watercolors, colored pencils, marker, pen and ink, or anything else you want to bring along. We will work on a still life, landscape (preferably outdoors), portrait, etc. Bring photos for reference or to paint from.', 1, 1, 1, 1, 1, 0, 25, 0, NOW(), NULL),
  (1143, 1123, 1002, 2, 'Writing Your Life\'s Song', 'Owen Burton', 'This song writing circle is a space to share songs, writing processes, and laughs. We will utilize specific writing techniques to help songwriters of any experience level. Bring your instrument, voice, or just a listening ear.', 1, 1, 1, 1, 1, 0, 20, 0, NOW(), NULL),
  (1144, 1123, 1002, 3, 'NOT Trivia BUT A Game of Things You Want to Know', 'Pam Carlson', 'Maybe I had the measles and missed learning so many of the things I wish I knew. Or maybe I didn\'t care so much when I was in school, or maybe I just don\'t remember. Any which way, if you enjoy learning as much as I do, join the fun and catch up! In a combination game of Trivia and Jeopardy, we team up to refresh our memories, test our knowledge and, learn new things while we laugh, groan, and get to know each other.', 1, 0, 1, 0, 1, 0, 25, 0, NOW(), NULL),
  (1145, 1123, 1002, 4, 'Book Discussion of Being Mortal by Atul Gawande', 'Libby Christianson and Pat Miller', 'Have you thought about how you will handle a health crisis for either yourself or a loved one? Join Pat Miller and Libby Christianson for an exploration of the best selling book, Being Mortal by Atul Gawande. We\'ll use the book to enlighten as we change the way we think about illness, healthcare, aging, and end of life choices. Workshop partipants should read the book prior to camp, and come to participate in some great discussions!', 0, 1, 0, 1, 0, 0, 24, 0, NOW(), NULL),
  (1146, 1123, 1002, 5, 'Singing the Folk Tradition', 'Steve Krahnke', 'Participants will sing and study folk songs including Woody Guthrie, Huddie Ledbetter, Pete Seeger, Lee Hays, Malvina Reynolds, Florence Reese and more. Experienced players and singers are welcome, as are those with no experience a all! We hope to perform a "set" of folk songs at a Coffeehouse.', 1, 1, 1, 1, 1, 0, 25, 0, NOW(), NULL),
  (1147, 1123, 1002, 6, 'Making Your Mark: A Fabric Journey', 'Stephanie Lewis Robertson', 'Students in this class are invited to explore dyes and pigments to decorate cloth. Techniques may include simple silk screen, silk painting, batik, and indigo. Students will explore methods and materials. All levels welcome. Lab fee pays for dyes, wax and auxiliaries, as well as the space for the workshop. Students will need to bring their own fabric and other supplies.', 1, 1, 1, 1, 1, 0, 20, 0, NOW(), NULL),
  (1148, 1123, 1002, 7, 'Introductory Swing Dance', 'Lawrence Lile and Qhyrrae (Kira) Michaelieu', 'Want to learn how to swing dance? We will teach you starting with the very basics and moving onto some nifty moves. You are encouraged to bring a Partner, but it is NOT required.', 1, 1, 1, 1, 1, 0, 20, 0, NOW(), NULL),
  (1149, 1123, 1002, 8, 'U Poet U', 'Carol Marks', 'Join genuine published poet Carol Hill Marks for three sessions of creative writing, focusing on a variety of poetic forms and techniques to help you get your writing flowing. The poetry of several contemporary and old-time poets will be shared, and we\'ll write our own poems during the workshop. Carol will encourage you to read aloud what you have written but will not require it. Bring your preferred writing implement and your imagination. A notebook for each participant will be provided. Recommended reading: The Artist\'s Way by Julia Cameron, Writing Down the Bones by Natalie Goldberg, and anything by Billy Collins.', 1, 0, 1, 0, 1, 0, 15, 0, NOW(), NULL),
  (1150, 1123, 1002, 9, 'Enneagram', 'David Mast', 'In this workshop we will study the personality typing system called the Enneagram, with the goal of gaining a deeper understanding of ourselves and how our personalities shape our interactions with family and friends. Experience with the Enneagram would be useful, but beginners are welcome.', 1, 1, 1, 1, 1, 0, 20, 0, NOW(), NULL),
  (1151, 1123, 1002, 10, 'Polyamory and Ethical Non-Monogamy', 'Kevin Nahm', 'Are you curious about polyamory, open relationships, and ethical non-monogamy? This workshop will explain these topics and create a safe space for deeper discussions.', 0, 1, 0, 1, 0, 0, 25, 0, NOW(), NULL),
  (1152, 1123, 1002, 11, 'Queer Allyship in Action', 'Taylor Paglisotti', 'This workshop will focus on allyship for people who identify as queer people of color, bisexual, pansexual, intersex, asexual, aromantic, andpolyamorous. We will practice allyship in everyday conversation using actvities based on real stories from Queer individuals. Participants will leave ready to challenge discriminatory language and policies at church, at work, and with family. Content will not overlap with Transgender Allyship in Action. (Feel free to take both!)', 0, 1, 0, 1, 0, 0, 20, 0, NOW(), NULL),
  (1153, 1123, 1002, 12, 'Trans Allyship in Action', 'Taylor Paglisotti', 'This workshop will focus on allyship for transgender people, especially trans people of color, and nonbinary trans people . We will practice allyship in everyday conversation using actvities based on real stories from Trans individuals. Participants will leave ready to challenge discriminatory language and policies at church, at work, and with family. Content will not overlap with Queer Allyship in Action. (Feel free to take both!)', 1, 0, 1, 0, 1, 0, 20, 0, NOW(), NULL),
  (1154, 1123, 1002, 13, 'Improv for Everyone', 'Thomas Robertson', 'An introductory level workshop covering the basics of short-form improv, including the "Yes, and" principle, character development, how to start a scene, what to do when you get "stuck," and finding your performance voice. New games make it interesting for returning participants; no prior performing experience needed. Depending on interest, the class may perform at evening Coffeehouse.', 1, 1, 1, 1, 1, 0, 20, 0, NOW(), NULL),
  (1155, 1123, 1003, 1, 'Intro to Zumba Fitness', 'Megan Barry-Luglio', 'Learn the basic steps of Zumba Fitness and then jump right into a fun workout. Zumba is a dance-based workout with a combination of Latin, world and pop music.', 1, 0, 1, 0, 0, 0, 30, 0, NOW(), NULL),
  (1156, 1123, 1003, 2, 'Beach Reads', 'Leah Krippner', 'A dirty little secret: more than half of YA titles published in this country are purchased by adults for their own reading pleasure. And they are delicious. Leah Krippner will highlight YA and Crossover titles to awe and inspire. Copies will be available so you can get started right away.', 1, 0, 0, 0, 0, 0, 30, 0, NOW(), NULL),
  (1157, 1123, 1003, 3, 'Class Conscious Potluck', 'Suzanne Zilber', 'This one day workshop will include sharing personal stories, readings or movie recommendations with others concerned about social class issues in America and our UU Association. We\'ll bring up sticky issue struggles, too. Suzanne will do a brief review on basic concepts for those who have not participated in prior workshops.', 1, 0, 0, 0, 0, 0, 16, 0, NOW(), NULL),
  (1158, 1123, 1003, 4, 'Creating Your Parting Gift', 'Rebecca Pace', 'Have you ever been asked to water a relative\'s plants whenthey were on vacation? Did they leave instructions? But what if that relative was never coming home again? This workshop will help you make the task of taking care of your things easier--important things, like bank accounts and insurance, and complicated things, like Aunt Margaret’s china and Grandmother’s quilt.', 1, 1, 0, 0, 0, 0, 20, 0, NOW(), NULL),
  (1159, 1123, 1004, 1, 'Beer Appreciation', 'Nate Warner',
         'In recent years, beer has widely become recognized as being really worth appreciating, at least to those who\'ve given it a whirl. Let\'s spend a few nights learning a bit more about nuances that make a beer really great.',
         1, 0, 1, 0, 1, 0, 25, 0, NOW(), NULL);

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


DROP PROCEDURE IF EXISTS update_workshops;
CREATE DEFINER =`root`@`localhost` PROCEDURE update_workshops()
  BEGIN
    UPDATE workshops w
    SET w.enrolled = (SELECT COUNT(*)
                      FROM yearattending__workshop yw
                      WHERE w.id = yw.workshopid);
    UPDATE yearattending__workshop yw, thisyear_campers tc, workshops w
      SET yw.is_leader = 1
    WHERE yw.workshopid=w.id AND yw.yearattendingid=tc.yearattendingid
          AND w.led_by LIKE CONCAT('%', tc.firstname, ' ', tc.lastname, '%');
  END;

DROP PROCEDURE IF EXISTS enroll_workshops;
CREATE DEFINER =`root`@`localhost` PROCEDURE enroll_workshops()
  BEGIN
    DECLARE done INT DEFAULT FALSE;
    DECLARE myid, mycapacity INT;
    DECLARE cur CURSOR FOR SELECT id, capacity-1 FROM workshops;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done=TRUE;

    UPDATE yearattending__workshop SET is_enrolled=0;

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

DROP FUNCTION IF EXISTS isprereg;
CREATE FUNCTION isprereg (id INT, myyear YEAR)
  RETURNS FLOAT DETERMINISTIC
  BEGIN
    RETURN (SELECT IF(IFNULL(SUM(h.amount),0) + 140 <= 0,ABS(SUM(h.amount)),0.0)
            FROM years y LEFT JOIN charges h ON h.camperid=id AND h.year=y.year AND h.timestamp<y.end_prereg
            WHERE y.year=myyear GROUP by h.camperid);
    -- Only works for 2014 or later
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