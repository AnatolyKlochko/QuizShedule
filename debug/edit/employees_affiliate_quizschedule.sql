-- Moodle sql
SELECT 
    qs.employeeid AS id, 
    CONCAT_WS(' ', u.lastname, u.firstname) AS name, 
    u.institution, 
    u.department, 
    qs.quizid, 
    qs.datenextquiz
FROM
    (
        SELECT
            id,
            CONCAT_WS( ' ', lastname, firstname ) AS name, 
            institution,
            department
        FROM
            {user}
        WHERE
            institution = :institution
    ) u 
    INNER JOIN {quizschedule} qs 
        ON u.id = qs.employeeid 
    INNER JOIN {quiz} q 
        ON qs.quizid = q.id
WHERE
    qs.quizid = :quizid
ORDER BY 
    u.name ASC





-- Direct sql
SELECT 
    qs.employeeid AS id, 
    CONCAT_WS(' ', u.lastname, u.firstname) AS name, 
    u.institution, 
    u.department, 
    qs.quizid, 
    qs.datenextquiz
FROM
    (
        SELECT
            id,
            CONCAT_WS( ' ', lastname, firstname ) AS name, 
            institution,
            department
        FROM
            mdl_user
        WHERE
            institution = 'АТ "ПОЛТАВАОБЛЕНЕРГО"'
    ) u 
    INNER JOIN mdl_quizschedule qs 
        ON u.id = qs.employeeid 
--    INNER JOIN mdl_quiz q 
--        ON qs.quizid = q.id
--WHERE
--    qs.quizid = 123
ORDER BY 
    u.name ASC