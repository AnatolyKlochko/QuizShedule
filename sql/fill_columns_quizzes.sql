/* To sure, query is right: only Екзамен, no Тренування: */
SELECT q.id, c.fullname
FROM mdl_quiz q INNER JOIN mdl_course c ON q.course=c.id
WHERE c.fullname LIKE '%кзамен%' AND c.fullname LIKE BINARY '% ОП %' /*  'ОП' 'ТР' 'ППБ' 'БПРП' 'БПРК'   */



/* Get a part of INSERT query for add appropriate quizzes to columns */

/* Process: 

NOTE: if query is not running, copy query text and OVERLOAD PAGE

- in phpmyadmin open {quizschedule_columns} table
- open 3 new clean SQL tabs (to perform sql queries)
- copy query below to first tab: */
SELECT "INSERT INTO mdl_quizschedule_columns_quizzes(columnid, quizid) VALUES " AS `INSERT`
UNION
SELECT CONCAT( '(colid,', q.id, '),') /* '(colid,' colid is column id (value of 'id' column), for instance - 7, 8, 9, etc. */
FROM mdl_quiz q INNER JOIN mdl_course c ON q.course=c.id
WHERE c.fullname LIKE '%кзамен%' AND c.fullname LIKE BINARY '% col_uk_abbr %' /*  col_uk_abbr: ОП ТР ППБ БПРП БПРК МО  */
/* ORDER BY q.id */ /* this line throws error *//*
- in query text replace: #1 - 'colid' with column id (only for columns with has_quiz=1) and #2 - 'col_uk_abbr'
- run query
- click on '+ Параметры' and choose 'Полные тексты', press 'Вперед'
- click on 'В буфер обмена'
- open second SQL tab[, Cntr+A], Cntr+V, at ending: delete spaces and one coma, at beginning: delete heading, run query
One 'Column-Quizzes' relation is added.
Do this steps for every column.
*/

