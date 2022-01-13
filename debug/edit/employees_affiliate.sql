-- Moodle sql
SELECT
    id,
    CONCAT_WS( ' ', lastname, firstname ) AS name, 
    institution,
    department
FROM
    {user}
WHERE
    institution = :institution

-- Direct sql
SELECT
    id,
    CONCAT_WS( ' ', lastname, firstname ) AS name, 
    institution,
    department
FROM
    mdl_user
WHERE
    institution = 'АТ "ПОЛТАВАОБЛЕНЕРГО"'
-- Гадяцька філія