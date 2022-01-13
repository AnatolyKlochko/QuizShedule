$studentsjoins => core\dml\sql_join object {
  joins => (string) JOIN {user_enrolments} ej1_ue ON ej1_ue.userid = u.id
JOIN {enrol} ej1_e ON (ej1_e.id = ej1_ue.enrolid AND ej1_e.courseid = :ej1_courseid)
  wheres => (string) 1 = 1 AND u.deleted = 0
  params => array(1) (
    [ej1_courseid] => (string) 37
  )
}

$allowedjoins => core\dml\sql_join object {
  joins => (string) JOIN {user_enrolments} ej1_ue ON ej1_ue.userid = u.id
JOIN {enrol} ej1_e ON (ej1_e.id = ej1_ue.enrolid AND ej1_e.courseid = :ej1_courseid)
  wheres => (string) 1 = 1 AND u.deleted = 0
  params => array(1) (
    [ej1_courseid] => (string) 37
  )
}

$this->qmsubselect = (string) (quiza.state = 'finished' AND NOT EXISTS (
                           SELECT 1 FROM {quiz_attempts} qa2
                            WHERE qa2.quiz = quiza.quiz AND
                                qa2.userid = quiza.userid AND
                                 qa2.state = 'finished' AND (
                COALESCE(qa2.sumgrades, 0) > COALESCE(quiza.sumgrades, 0) OR
               (COALESCE(qa2.sumgrades, 0) = COALESCE(quiza.sumgrades, 0) AND qa2.attempt < quiza.attempt)
                                )))

SELECT DISTINCT u.id
FROM {user} u JOIN {user_enrolments} ej1_ue ON ej1_ue.userid = u.id
    JOIN {enrol} ej1_e ON (ej1_e.id = ej1_ue.enrolid AND ej1_e.courseid = :ej1_courseid)
WHERE 1 = 1 AND u.deleted = 0
-
SELECT DISTINCT u.id
FROM mdl_user u JOIN mdl_user_enrolments ej1_ue ON ej1_ue.userid = u.id JOIN mdl_enrol ej1_e ON (ej1_e.id = ej1_ue.enrolid AND ej1_e.courseid = ?)
WHERE 1 = 1 AND u.deleted = 0 LIMIT 0, 1



SELECT 
    DISTINCT CONCAT(u.id, '#', COALESCE(quiza.attempt, 0)) AS uniqueid,
    (CASE 
        WHEN (quiza.state = 'finished' AND NOT EXISTS (
                SELECT 1 FROM mdl_quiz_attempts qa2
                WHERE qa2.quiz = quiza.quiz AND qa2.userid = quiza.userid AND qa2.state = 'finished' AND (
                    COALESCE(qa2.sumgrades, 0) > COALESCE(quiza.sumgrades, 0) OR 
                    (COALESCE(qa2.sumgrades, 0) = COALESCE(quiza.sumgrades, 0) AND qa2.attempt < quiza.attempt)))) 
        THEN 1
        ELSE 0 
    END
    ) AS gradedattempt,
    quiza.uniqueid AS usageid,
    quiza.id AS attempt,
    u.id AS userid,
    u.idnumber, u.firstnamephonetic,u.lastnamephonetic,u.middlename,u.alternatename,u.firstname,u.lastname,
    u.picture,
    u.imagealt,
    u.institution,
    u.department,
    u.email,
    quiza.state,
    quiza.sumgrades,
    quiza.timefinish,
    quiza.timestart,
    CASE 
        WHEN quiza.timefinish = 0 THEN null
        WHEN quiza.timefinish > quiza.timestart THEN quiza.timefinish - quiza.timestart
        ELSE 0
    END AS duration,
    COALESCE((SELECT MAX(qqr.regraded) FROM mdl_quiz_overview_regrades qqr WHERE qqr.questionusageid = quiza.uniqueid), -1) AS regraded
FROM  mdl_user u LEFT JOIN mdl_quiz_attempts quiza ON quiza.userid = u.id AND quiza.quiz = '36'
WHERE quiza.id IS NOT NULL AND quiza.preview = 0
ORDER BY quiza.id ASC
LIMIT 0, 30


--17 May 2019 г, 13 May 2019, 14 May 2019
SELECT
                DISTINCT CONCAT(u.id, '#', COALESCE(quiza.attempt, 0)) AS uniqueid,
(CASE WHEN (quiza.state = 'finished' AND NOT EXISTS (
                           SELECT 1 FROM mdl_quiz_attempts qa2
                            WHERE qa2.quiz = quiza.quiz AND
                                qa2.userid = quiza.userid AND
                                 qa2.state = 'finished' AND (
                COALESCE(qa2.sumgrades, 0) > COALESCE(quiza.sumgrades, 0) OR
               (COALESCE(qa2.sumgrades, 0) = COALESCE(quiza.sumgrades, 0) AND qa2.attempt < quiza.attempt)
                                ))) THEN 1 ELSE 0 END) AS gradedattempt,
                quiza.uniqueid AS usageid,
                quiza.id AS attempt,
                u.id AS userid,
                u.idnumber, u.firstnamephonetic,u.lastnamephonetic,u.middlename,u.alternatename,u.firstname,u.lastname,
                u.picture,
                u.imagealt,
                u.institution,
                u.department,
                u.email,
                quiza.state,
                quiza.sumgrades,
                quiza.timefinish,
                quiza.timestart,
                CASE WHEN quiza.timefinish = 0 THEN null
                     WHEN quiza.timefinish > quiza.timestart THEN quiza.timefinish - quiza.timestart
                     ELSE 0 END AS duration, COALESCE((
                                SELECT MAX(qqr.regraded)
                                  FROM mdl_quiz_overview_regrades qqr
                                 WHERE qqr.questionusageid = quiza.uniqueid
                          ), -1) AS regraded
                FROM  mdl_user u
LEFT JOIN mdl_quiz_attempts quiza ON
                                    quiza.userid = u.id AND quiza.quiz = '36'
                WHERE quiza.id IS NOT NULL  AND quiza.timefinish >= '2016-05-10' AND quiza.timefinish <= '2019-05-30' 
                ORDER BY quiza.timefinish DESC LIMIT 0, 30