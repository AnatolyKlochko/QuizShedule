# All ТР quizzes
# OR ТР quizzes with ППБ
SELECT cq.id cq_id, c.name_uk, q.name
FROM
    mdl_quizschedule_columns_quizzes cq
    INNER JOIN mdl_quizschedule_columns c ON cq.columnid = c.id
    INNER JOIN mdl_quiz q ON q.id = cq.quizid
WHERE
    c.name_uk = 'ТР' 
#    AND q.name LIKE '%ППБ%'



# All 'ОП' quizzes
# OR 'ОП' quizzes with 'ТР'
# OR/AND 'ОП' quizzes with 'ППБ'
SELECT cq.id cq_id, c.name_uk, q.name
FROM
    mdl_quizschedule_columns_quizzes cq
    INNER JOIN mdl_quizschedule_columns c ON cq.columnid = c.id
    INNER JOIN mdl_quiz q ON q.id = cq.quizid
WHERE
    c.name_uk = 'ОП' 
   # AND q.name LIKE '%ТР%'
   # AND q.name LIKE '%ППБ%'
    AND q.name LIKE '%ППТ%'
