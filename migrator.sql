DROP PROCEDURE IF EXISTS workshops;
CREATE DEFINER =`root`@`localhost` PROCEDURE workshops()
  BEGIN
    DECLARE done INT DEFAULT FALSE;
    DECLARE myid, mycapacity INT;
    DECLARE cur CURSOR FOR SELECT
                             id,
                             capacity - 1
                           FROM workshops;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
    SET sql_mode='';

    UPDATE yearattending__workshop
    SET is_enrolled = 0;

    UPDATE workshops w
    SET w.enrolled = (SELECT COUNT(*)
                      FROM yearattending__workshop yw
                      WHERE w.id = yw.workshopid);
    UPDATE yearattending__workshop yw, thisyear_campers tc, workshops w
    SET yw.is_leader = 1
    WHERE yw.workshopid = w.id AND yw.yearattendingid = tc.yearattendingid
          AND w.led_by LIKE CONCAT('%', tc.firstname, ' ', tc.lastname, '%');

    OPEN cur;

    read_loop: LOOP
      FETCH cur
      INTO myid, mycapacity;
      IF done
      THEN
        LEAVE read_loop;
      END IF;
      UPDATE yearattending__workshop yw
      SET yw.is_enrolled = 1
      WHERE yw.workshopid = myid AND (yw.is_leader = 1 OR
                                      yw.created_at <= (SELECT MAX(created_at)
                                                        FROM
                                                          (SELECT ywp.created_at
                                                           FROM yearattending__workshop ywp
                                                           WHERE ywp.workshopid = myid AND ywp.is_leader = 0
                                                           ORDER BY created_at
                                                           LIMIT mycapacity)
                                                            AS t1));
    END LOOP;

    CLOSE cur;

  END;

DROP PROCEDURE IF EXISTS `duplicate`;
CREATE DEFINER =`root`@`localhost` PROCEDURE `duplicate`(beforeid INT, afterid INT)
  BEGIN
    DECLARE family, count INT DEFAULT 0;
    IF beforeid != 0 AND afterid != 0
    THEN
      SELECT familyid
      INTO family
      FROM campers
      WHERE id = beforeid;
      UPDATE yearsattending ya
      SET ya.camperid = afterid
      WHERE ya.camperid = beforeid AND (SELECT COUNT(*)
                                        FROM yearsattending yap
                                        WHERE yap.camperid = afterid AND ya.year = yap.year) = 0;
      UPDATE oldgencharges
      SET camperid = afterid
      WHERE camperid = beforeid;
      UPDATE gencharges
      SET camperid = afterid
      WHERE camperid = beforeid;
      UPDATE charges
      SET camperid = afterid
      WHERE camperid = beforeid;
      DELETE FROM campers
      WHERE id = beforeid;
      SELECT COUNT(*)
      INTO count
      FROM campers
      WHERE familyid = family;
      IF count = 0
      THEN
        DELETE FROM families
        WHERE id = family;
      END IF;
    END IF;
  END;

DROP FUNCTION IF EXISTS getprogramidbycamperid;

DROP FUNCTION IF EXISTS getprogramidbyname;
CREATE FUNCTION getprogramidbyname(programname VARCHAR(1024))
  RETURNS INT DETERMINISTIC BEGIN
  RETURN (SELECT p.id
          FROM programs p
          WHERE p.name LIKE CONCAT('%', programname, '%')
          ORDER BY display DESC
          LIMIT 1);
END;
